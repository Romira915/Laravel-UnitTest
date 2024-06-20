<?php

namespace Database\Seeders;

use App\Models\ArticleDetailEloquent;
use App\Models\ArticleEloquent;
use App\Models\ArticleImageEloquent;
use App\Models\ArticlePublishedEloquent;
use App\Models\UserEloquent;
use Illuminate\Database\Seeder;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 50; $i++) {
            $random_choice_user_id = UserEloquent::query()->inRandomOrder()->first()->id;
            ArticleEloquent::factory(10)
                ->state(['user_id' => $random_choice_user_id])
                ->has(ArticlePublishedEloquent::factory(1)->state(['user_id' => $random_choice_user_id]))
                ->has(ArticleDetailEloquent::factory(1)->state(['user_id' => $random_choice_user_id]))
                ->has(ArticleImageEloquent::factory(5)->state(['user_id' => $random_choice_user_id]))
                ->create();
        }

        $test_user_id = UserEloquent::with('userDetailEloquent')
            ->whereRelation('userDetailEloquent', 'display_name', 'test')
            ->first()
            ->id;
        ArticleEloquent::factory(10)
            ->state(['user_id' => $test_user_id])
            ->has(ArticlePublishedEloquent::factory(1)->state(['user_id' => $test_user_id]))
            ->has(ArticleDetailEloquent::factory(1)->state(['user_id' => $test_user_id]))
            ->has(ArticleImageEloquent::factory(5)->state(['user_id' => $test_user_id]))
            ->create();
    }
}
