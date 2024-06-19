<?php /** @noinspection NonAsciiCharacters */

namespace Tests\Unit\Infrastructure\QueryServices;

use App\Infrastructure\QueryServices\ArticleSummaryQueryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleSummaryQueryServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_limitが1以上の場合、DTOの配列が返ってくること(): void
    {
        $queryService = new ArticleSummaryQueryService();
        $articles = $queryService->getArticleSummaryList(20);

        $this->assertCount(20, $articles);
        $this->assertIsObject($articles[0]);
    }

    public function test_limitが0の場合、空の配列が返ってくること(): void
    {
        $queryService = new ArticleSummaryQueryService();
        $articles = $queryService->getArticleSummaryList(0);

        $this->assertIsArray($articles);
        $this->assertCount(0, $articles);
    }

    public function test_limitが負の値の場合、空の配列が返ってくること(): void
    {
        $queryService = new ArticleSummaryQueryService();
        $articles = $queryService->getArticleSummaryList(-1);

        $this->assertCount(0, $articles);
    }
}
