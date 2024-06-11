<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleDetail;
use App\Models\ArticlePublished;
use Illuminate\Database\Seeder;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Article::factory(50)->has(ArticlePublished::factory(1))->has(ArticleDetail::factory(1))->create();
    }
}
