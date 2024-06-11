<?php

namespace Database\Factories;

use App\Models\ArticleDetailEloquent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ArticleDetailEloquent>
 */
class ArticleDetailEloquentFactory extends Factory
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
            'title' => $this->faker->sentence(),
            'body' => $this->faker->text(8000),
            'thumbnail_path' => $this->faker->filePath(),
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}
