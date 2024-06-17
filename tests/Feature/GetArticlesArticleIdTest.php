<?php /** @noinspection NonAsciiCharacters */

namespace Tests\Feature;

use App\Models\ArticleDetailEloquent;
use App\Models\ArticleEloquent;
use App\Models\ArticleImageEloquent;
use App\Models\ArticlePublishedEloquent;
use Tests\TestCase;

class GetArticlesArticleIdTest extends TestCase
{
    public function test_記事詳細ページを表示できること()
    {
        $testArticle = ArticleEloquent::factory()
            ->has(ArticlePublishedEloquent::factory())
            ->has(ArticleDetailEloquent::factory())
            ->has(ArticleImageEloquent::factory(5))
            ->create();

        $response = $this->get('/articles/' . $testArticle->id);

        $response->assertStatus(200);
        $response->assertSee($testArticle->articleDetailEloquent->title);
        $response->assertSee($testArticle->articleDetailEloquent->body);
        $response->assertSee(config('image.base_url') . $testArticle->articleDetailEloquent->thumbnail_path);
        foreach ($testArticle->articleImageEloquent as $image) {
            $response->assertSee(config('image.base_url') . $image->image_path);
        }
    }

    public function test_存在しない記事IDを指定した場合404エラーが返ること()
    {
        $article_id = 'not_exist_article_id';

        $response = $this->get('/articles/' . $article_id);

        $response->assertStatus(404);
    }
}
