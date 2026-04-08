<?php

namespace Database\Factories;

use App\Models\InviteLink;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/** @extends Factory<InviteLink> */
class InviteLinkFactory extends Factory
{
    public function definition(): array
    {
        return [
            'token' => Str::random(10),
            'rotated_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
