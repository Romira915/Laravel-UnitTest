<?php

namespace Database\Seeders;

use App\Models\ArticleDetailEloquent;
use App\Models\ArticleEloquent;
use App\Models\ArticlePublishedEloquent;
use Illuminate\Database\Seeder;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ArticleEloquent::factory(50)->has(ArticlePublishedEloquent::factory(1))->has(ArticleDetailEloquent::factory(1))->create();
    }
}
