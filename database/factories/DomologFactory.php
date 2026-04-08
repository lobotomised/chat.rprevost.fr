<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Domolog;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Domolog> */
class DomologFactory extends Factory
{
    public function definition(): array
    {
        return [
            'type' => $this->faker->word(),
            'model' => $this->faker->word(),
            'message' => $this->faker->word(),
            'context' => $this->faker->words(),
            'user' => $this->faker->word(),
            'stack_trace' => $this->faker->word(),
            'request_uri' => $this->faker->word(),
            'referer' => $this->faker->word(),
            'ip' => $this->faker->ipv4(),
        ];
    }
}
