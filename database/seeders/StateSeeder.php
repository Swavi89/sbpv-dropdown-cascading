<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            'Odisha',
            'West Bengal',
            'Jharkhand'
        ];

        foreach ($states as $state) {
            \App\Models\State::create(['state_name' => $state]);
        }
    }
}
