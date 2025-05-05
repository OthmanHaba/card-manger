<?php

namespace Database\Seeders;

use App\Enums\CardStatusEnum;
use App\Enums\WorkStatusEnum;
use App\Models\Card;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@admin.com',
        ]);

        Card::factory()->create([
            'name' => 'Test Card',
            'status' => WorkStatusEnum::BOOKED,
            'matching_state' => CardStatusEnum::NEW_CARD,
        ]);
    }
}
