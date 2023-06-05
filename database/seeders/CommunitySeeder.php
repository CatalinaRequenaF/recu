<?php

namespace Database\Seeders;

use App\Models\Community;
use Database\Factories\CommunityFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Community::factory(3);
    }
}
