<?php

namespace Database\Seeders;

use App\Models\Log;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(int $count = 5): void
    {
        $users = User::all();

        foreach ($users as $user) {
            Log::factory()
                ->count($count)
                ->for($user)
                ->create();
        }
    }
}
