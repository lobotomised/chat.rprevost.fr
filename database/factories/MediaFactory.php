<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Media>
 */
class MediaFactory extends Factory
{
    public function definition(): array
    {
        $type = $this->faker->randomElement(['image', 'video']);
        $extension = $type === 'image' ? 'jpg' : 'mp4';

        return [
            'uploader_id' => User::factory(),
            'type' => $type,
            'path' => "media/{$this->faker->uuid}.$extension",
            'thumb_path' => $type === 'video'
                ? "media/thumbs/{$this->faker->uuid}.jpg"
                : null,
            'mime' => $type === 'image' ? 'image/jpeg' : 'video/mp4',
            'size_bytes' => $this->faker->numberBetween(50_000, 8_000_000),
        ];
    }
}
