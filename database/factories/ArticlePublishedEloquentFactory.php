<?php

namespace Database\Factories;

use App\Models\ArticlePublishedEloquent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ArticlePublishedEloquent>
 */
class ArticlePublishedEloquentFactory extends Factory
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
