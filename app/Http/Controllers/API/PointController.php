<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessResponse;
use App\Models\Point;
use App\Models\PointHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PointController extends Controller
{
    public function luckyDraw(Request $request)
    {
        $user = $request->user();
        $point = $this->getCurrentPoint($user);
        $isValid = $this->validateLuckyDraw($point);
        if (!$isValid) {
            return new ErrorResponse('Please get lucky draw on tomorrow!', null, 409);
        }
        $pointNumber = $this->getPointNumber();
        $this->savePoint($point, $pointNumber);

        return new SuccessResponse('Ok!', $point);
    }

    private function getCurrentPoint(User $user): Point
    {
        $point = Point::firstWhere(['user_id' => $user->id]);
        if (!$point) {
            $point = Point::create([
                'user_id' => $user->id,
                'status' => 1,
            ]);
        }

        return $point;
    }

    private function validateLuckyDraw(Point $point): bool
    {
        $pointHistory = PointHistory::where('point_id', $point->id)
            ->whereDate('created_at', DB::raw('CURDATE()'))
            ->get();

        if ($pointHistory->count() > 0) {
            return false;
        }

        return true;
    }

    private function getPointNumber(): int
    {
        return rand(1, 100);
    }

    private function savePoint(Point $point, int $pointNumber)
    {
        $point->point_value += $pointNumber;
        $point->save();

        PointHistory::create([
            'point_id' => $point->id,
            'point_value' => $pointNumber,
            'type' => 1,
        ]);
    }
}
