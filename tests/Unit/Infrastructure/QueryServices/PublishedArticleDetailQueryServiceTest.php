<?php /** @noinspection NonAsciiCharacters */

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\QueryServices;

use App\Exception\ArticleNotFoundException;
use App\Infrastructure\QueryServices\PublishedArticleDetailQueryService;
use App\Models\ArticleDetailEloquent;
use App\Models\ArticleEloquent;
use App\Models\ArticleImageEloquent;
use App\Models\ArticlePublishedEloquent;
use App\Models\UserEloquent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublishedArticleDetailQueryServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_記事情報を取得できること()
    {
        $user_id = UserEloquent::query()->inRandomOrder()->first()->id;
        $queryService = new PublishedArticleDetailQueryService();

        $testArticle = ArticleEloquent::factory()
            ->state(['user_id' => $user_id])
            ->has(ArticlePublishedEloquent::factory()->state(['user_id' => $user_id]))
            ->has(ArticleDetailEloquent::factory()->state(['user_id' => $user_id]))
            ->has(ArticleImageEloquent::factory(5)->state(['user_id' => $user_id]))
            ->create();

        $article_dto = $queryService->getPublishedArticleDetail($testArticle->id);

        $this->assertNotSame(ArticleNotFoundException::class, $article_dto::class);
        $this->assertSame($testArticle->id, $article_dto->article_id);
        $this->assertSame($testArticle->user_id, $article_dto->user_id);
        $this->assertSame($testArticle->articleDetailEloquent->title, $article_dto->title);
    }

    public function test_存在しない記事IDを指定した場合Nullが返ること()
    {
        $queryService = new PublishedArticleDetailQueryService();

        $article_id = 'not_exist_article_id';

        $article_dto = $queryService->getPublishedArticleDetail($article_id);

        $this->assertNull($article_dto);
    }
}
