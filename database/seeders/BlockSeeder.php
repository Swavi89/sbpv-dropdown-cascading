<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blocks = [
            ['state_id' => 1, 'block_name' => 'Bhubaneswar'],
            ['state_id' => 1, 'block_name' => 'Cuttack'],
            ['state_id' => 2, 'block_name' => 'Kolkata'],
            ['state_id' => 2, 'block_name' => 'Howrah'],
            ['state_id' => 3, 'block_name' => 'Ranchi'],
        ];
        foreach ($blocks as $block) {
            \App\Models\Block::create($block);
        }
    }
}
