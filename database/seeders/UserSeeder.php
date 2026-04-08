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
            ->count(20)
            ->create()
            ->each(function (User $user) {
                InviteLink::create([
                    'user_id' => $user->id,
                    'token' => hash('sha256', Str::random(64)),
                ]);
            });
    }
}
