<?php

namespace App\Repositories;

use App\Models\Point;
use App\Models\PointHistory;

class PointRepository
{
    public function update(array $attributes, int $id)
    {
        $point = Point::find($id);

        return $point->update($attributes);
    }

    public function createHistory(array $attributes, Point $point)
    {
        return PointHistory::create(array_merge($attributes, ['point_id' => $point->id]));
    }
}
