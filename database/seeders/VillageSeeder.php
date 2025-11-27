<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $villages = [
            ['panchayat_id' => 1, 'village_name' => 'Patia-A'],
            ['panchayat_id' => 2, 'village_name' => 'Link Road-A'],
            ['panchayat_id' => 3, 'village_name' => 'Baranagar-A'],
            ['panchayat_id' => 4, 'village_name' => 'Dankuni-A'],
            ['panchayat_id' => 5, 'village_name' => 'Dassam-A'],
        ];
        foreach ($villages as $village) {
            \App\Models\Village::create($village);
        }
    }
}
