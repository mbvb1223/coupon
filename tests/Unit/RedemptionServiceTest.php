<?php

namespace Tests\Unit;

use App\Exceptions\InvalidRedeemDataException;
use App\Http\Helpers\CommonHelper;
use App\Models\Coupon;
use App\Models\CouponCategory;
use App\Models\Point;
use App\Models\Redemption;
use App\Models\User;
use App\Repositories\RedemptionRepository;
use App\Services\CouponService;
use App\Services\PointService;
use App\Services\RedemptionService;
use Mockery;
use Tests\TestCase;

class RedemptionServiceTest extends TestCase
{
    /**
     * @var RedemptionService
     */
    private $redemptionService;

    /**
     * @var PointService|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    private $pointService;

    /**
     * @var RedemptionRepository|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    private $redemptionRepository;

    /**
     * @var CouponService|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    private $couponService;

    /**
     * @var CommonHelper|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    private $commonHelper;

    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->redemptionRepository = Mockery::mock(RedemptionRepository::class);
        $this->pointService = Mockery::mock(PointService::class);
        $this->couponService = Mockery::mock(CouponService::class);
        $this->commonHelper = Mockery::mock(CommonHelper::class);

        $this->redemptionService = new RedemptionService(
            $this->redemptionRepository,
            $this->pointService,
            $this->couponService,
            $this->commonHelper
        );
    }

    /**
     * @inheritdoc
     */
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testRedeemWithDisabledCouponCategory()
    {
        $this->expectException(InvalidRedeemDataException::class);
        $this->expectExceptionMessage('Coupon is not active!');

        $couponCategory = new CouponCategory(['status' => config('constant.coupon.statues.disable')]) ;
        $user = new User(['name' => 'Khien']);

        $this->redemptionService->redeem($couponCategory, $user);
    }

    public function testRedeemWithCouponCategoryQuotaExceed()
    {
        $this->expectException(InvalidRedeemDataException::class);
        $this->expectExceptionMessage('Coupon quota exceeded!');

        $couponCategory = new CouponCategory(
            ['status' => config('constant.coupon.statues.enable'), 'quota' => null]
        ) ;
        $user = new User(['name' => 'Khien']);

        $this->redemptionService->redeem($couponCategory, $user);
    }

    public function testRedeemWhenUserDoesNotHaveEnoughPoint()
    {
        $this->expectException(InvalidRedeemDataException::class);
        $this->expectExceptionMessage('You do not have enough Point!');

        $couponCategory = new CouponCategory(
            ['status' => config('constant.coupon.statues.enable'), 'quota' => 100]
        ) ;
        $user = new User(['name' => 'Khien']);

        $this->redemptionService->redeem($couponCategory, $user);
    }

    public function testRedeemSuccessfully()
    {
        $couponCategoryId = 111;
        $couponCategory = new CouponCategory(
            [
                'status' => config('constant.coupon.statues.enable'),
                'quota' => 100,
                'price' => 500,
                'required_point' => 10
            ]
        ) ;
        $couponCategory->id = $couponCategoryId;
        $userId = 9999;
        $user = new User(['name' => 'Khien']);
        $user->id = $userId;
        $user->point = new Point(['point_value' => 100]);

        $redemption = new Redemption();
        $this->redemptionRepository
            ->shouldReceive('create')
            ->with([
                'user_id' => $userId,
                'coupon_category_id' => $couponCategoryId,
            ])->andReturn($redemption);

        $key = 'test123123123';
        $this->commonHelper
            ->shouldReceive('hashSha256')
            ->with(40)
            ->andReturn($key);
        $strCode = "$user->name | $key";
        $qrCode = 'Qrcode';
        $this->commonHelper
            ->shouldReceive('bash64QrCode')
            ->with($strCode)
            ->andReturn($qrCode);
        $coupon = new Coupon(['key' => 'khien test key']);
        $this->couponService
            ->shouldReceive('create')
            ->with([
                'key' => $key,
                'status' => config('constant.coupon.statues.enable'),
                'quota' => 1,
                'qr' => $qrCode,
                'price' => $couponCategory->price,
                'type' => config('constant.coupon.types.one_time'),
                'redemption_id' => $redemption->id,
            ])->andReturn($coupon);

        $this->pointService
            ->shouldReceive('decrease')
            ->andReturnSelf();
        $this->couponService
            ->shouldReceive('updateCategory')
            ->andReturnSelf();

        $actualCoupon = $this->redemptionService->redeem($couponCategory, $user);

        $this->assertTrue($actualCoupon instanceof Coupon);
        $this->assertEquals($coupon->key, $actualCoupon->key);
    }
}
