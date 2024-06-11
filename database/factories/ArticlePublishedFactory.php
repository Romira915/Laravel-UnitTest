<?php

namespace Database\Factories;

use App\Models\ArticlePublished;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ArticlePublished>
 */
class ArticlePublishedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'article_id' => $this->faker->uuid(),
            'user_id' => $this->faker->uuid(),
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}
