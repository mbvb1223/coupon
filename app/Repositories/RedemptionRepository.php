<?php

namespace App\Repositories;

use App\Models\Redemption;

class RedemptionRepository
{
    public function create(array $attributes)
    {
        return Redemption::create($attributes);
    }
}
