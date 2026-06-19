<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestaurantTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('restaurant_tables')->delete();

        for ($i = 1; $i <= 21; $i++) {
            DB::table('restaurant_tables')->insert([
                'table_number' => 'Table ' . $i,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
