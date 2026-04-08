<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\InviteLink;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->has(InviteLink::factory()->state(['token' => '1234']))
            ->create(['name' => 'admin', 'email' => 'admin@exemple.com']);

        User::factory()
            ->count(20)
            ->create()
            ->each(function (User $user) {
                InviteLink::create([
                    'user_id' => $user->id,
                    'token' => Str::random(32),
                ]);
            });
    }
}
