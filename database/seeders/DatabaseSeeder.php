<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->createUsers();
        $this->createCoupons();
    }

    private function createUsers()
    {
        $user = User::create([
            'name' => 'Khien Pham',
            'email' => 'phamkhien@hotmail.com',
            'password' => '$2y$10$A31UjoEpC/MCHRtvcGgPQeVKqHRdo.LBGLtA/RzDtUNijxNM37/0i', // 123456
        ]);

        $user->tokens()->create([
            'name' => 'tester',
            'token' => hash('sha256', 'EFEm0c4dvKVnckTRrGznJdV4qTR1js7gC4h7Eef8'),
            'abilities' => ['*'],
        ]);
    }

    private function createCoupons()
    {
        Coupon::create([
            'name' => 'Christmas 2023',
            'quota' => 200,
            'required_point' => 50,
            'status' => config('constant.coupon.statues.enable'),
            'price' => 500
        ]);

        Coupon::create([
            'name' => 'New Year 2023',
            'quota' => 100,
            'required_point' => 1,
            'status' => config('constant.coupon.statues.enable'),
            'price' => 10
        ]);
    }
}
