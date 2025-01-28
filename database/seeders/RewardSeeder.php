<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rewards')->insert([
            [
                'title' => 'Exclusive Access',
                'description' => 'Redeem this privilege for exclusive access to our premium features.',
                'points_required' => 500,
                'valid_until' => Carbon::now()->addMonths(6),
                'image' => 'https://developers.elementor.com/docs/assets/img/elementor-placeholder-image.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Discount Coupon',
                'description' => 'Enjoy a 20% discount on your next purchase with this reward.',
                'points_required' => 300,
                'valid_until' => Carbon::now()->addMonths(3),
                'image' => 'https://developers.elementor.com/docs/assets/img/elementor-placeholder-image.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Free Coffee',
                'description' => 'Enjoy a free cup of coffee at any participating outlet.',
                'points_required' => 100,
                'valid_until' => Carbon::now()->addYear(),
                'image' => 'https://developers.elementor.com/docs/assets/img/elementor-placeholder-image.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
