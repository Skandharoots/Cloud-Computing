<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Database\Seeder;

class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(int $count = 5): void
    {
        $users = User::all();

        foreach ($users as $user) {
            UserPermission::factory()
                ->count($count)
                ->for($user)
                ->create();
        }
    }
}
