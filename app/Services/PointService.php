<?php

namespace App\Services;

use App\Models\Point;
use App\Repositories\PointRepository;

class PointService
{
    /**
     * @var PointRepository
     */
    private $pointRepository;

    public function __construct(PointRepository $pointRepository)
    {
        $this->pointRepository = $pointRepository;
    }

    public function decrease(Point $point, int $pointValue)
    {
        $this->pointRepository->update(['point_value' => $point->point_value - $pointValue], $point->id);

        $this->pointRepository->createHistory([
            'point_value' => -$pointValue,
            'type' => config('constant.point_history.types.decrease'),
        ], $point);
    }
}
