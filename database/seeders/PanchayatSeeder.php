<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PanchayatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $panchayats = [
            ['block_id' => 1, 'panchayat_name' => 'Patia'],
            ['block_id' => 2, 'panchayat_name' => 'Link Road'],
            ['block_id' => 3, 'panchayat_name' => 'Baranagar'],
            ['block_id' => 4, 'panchayat_name' => 'Dankuni'],
            ['block_id' => 5, 'panchayat_name' => 'Dassam'],
        ];
        foreach ($panchayats as $panchayat) {
            \App\Models\Panchayat::create($panchayat);
        }
    }
}
