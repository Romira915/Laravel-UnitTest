<?php /** @noinspection NonAsciiCharacters */

namespace Tests\Unit;

use App\Domain\Article\Collection\ArticleImageList;
use App\Domain\Article\Entities\ArticleImage;
use App\Domain\Article\Entities\PublishedArticle;
use App\Infrastructure\Persistence\PublishedArticleRepository;
use App\Models\ArticleDetailEloquent;
use App\Models\ArticleEloquent;
use App\Models\ArticleImageEloquent;
use App\Models\ArticlePublishedEloquent;
use App\Models\UserEloquent;
use App\Utils\Uuid;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublishedArticleRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private $user_id;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user_id = UserEloquent::query()->first()->id;
    }

    public function test_存在しないエンティティをsaveしたときに新規に保存されること(): void
    {
        $article_id = Uuid::generate();

        $publishedArticle = new PublishedArticle(
            user_id: $this->user_id,
            title: 'Test title',
            body: 'Test body',
            thumbnail_path: 'test.jpg',
            images: new ArticleImageList([
                new ArticleImage(
                    image_path: 'test.jpg',
                    user_id: $this->user_id,
                ),
                new ArticleImage(
                    image_path: 'test2.jpg',
                    user_id: $this->user_id,
                ),
            ]),
            id: $article_id
        );

        PublishedArticleRepository::save($publishedArticle);

        $this->assertDatabaseHas('articles', [
            'id' => $publishedArticle->getId(),
        ]);
        $this->assertDatabaseHas('article_published', [
            'article_id' => $publishedArticle->getId(),
        ]);
        $this->assertDatabaseHas('article_details', [
            'article_id' => $publishedArticle->getId(),
            'title' => 'Test title',
        ]);
        $this->assertDatabaseHas('article_images', [
            'article_id' => $publishedArticle->getId(),
            'image_path' => 'test.jpg'
        ]);
        $this->assertCount(2, ArticleImageEloquent::query()->where('article_id', $publishedArticle->getId())->get());
    }

    public function test_存在するエンティティをsaveしたときに更新されること(): void
    {
        $article_id = Uuid::generate();

        $publishedArticle = new PublishedArticle(
            user_id: $this->user_id,
            title: 'Test title',
            body: 'Test body',
            thumbnail_path: 'test.jpg',
            images: new ArticleImageList([
                new ArticleImage(
                    image_path: 'test.jpg',
                    user_id: $this->user_id,
                ),
                new ArticleImage(
                    image_path: 'test2.jpg',
                    user_id: $this->user_id,
                ),
            ]),
            id: $article_id
        );

        PublishedArticleRepository::save($publishedArticle);

        $publishedArticle = new PublishedArticle(
            user_id: $this->user_id,
            title: 'Updated title',
            body: 'Updated body',
            thumbnail_path: 'test.jpg',
            images: new ArticleImageList([
                new ArticleImage(
                    image_path: 'updated.jpg',
                    user_id: $this->user_id,
                ),
                new ArticleImage(
                    image_path: 'updated2.jpg',
                    user_id: $this->user_id,
                ),
            ]),
            id: $article_id,
        );

        PublishedArticleRepository::save($publishedArticle);

        $this->assertDatabaseHas('articles', [
            'id' => $publishedArticle->getId(),
        ]);
        $this->assertDatabaseHas('article_published', [
            'article_id' => $publishedArticle->getId(),
        ]);
        $this->assertDatabaseHas('article_details', [
            'article_id' => $publishedArticle->getId(),
            'title' => 'Updated title',
            'body' => 'Updated body',
        ]);
        $this->assertDatabaseHas('article_images', [
            'article_id' => $publishedArticle->getId(),
            'image_path' => 'updated.jpg'
        ]);
        $this->assertCount(2, ArticleImageEloquent::query()->where('article_id', $publishedArticle->getId())->get());
    }

    public function test_存在するエンティティをdeleteしたときに削除されること(): void
    {
        $article_id = Uuid::generate();

        $publishedArticle = new PublishedArticle(
            user_id: $this->user_id,
            title: 'Test title',
            body: 'Test body',
            thumbnail_path: 'test.jpg',
            images: new ArticleImageList([
                new ArticleImage(
                    image_path: 'test.jpg',
                    user_id: $this->user_id,
                ),
                new ArticleImage(
                    image_path: 'test2.jpg',
                    user_id: $this->user_id,
                ),
            ]),
            id: $article_id
        );

        $testArticle = ArticleEloquent::factory()
            ->state(['user_id' => $this->user_id])
            ->has(ArticlePublishedEloquent::factory()->state(['user_id' => $this->user_id]))
            ->has(ArticleDetailEloquent::factory()->state([
                'user_id' => $this->user_id,
                'title' => 'Test title',
                'body' => 'Test body',
                'thumbnail_path' => 'test.jpg',
            ]))
            ->has(ArticleImageEloquent::factory(1)->state([
                'user_id' => $this->user_id,
                'image_path' => 'test.jpg',
            ]))
            ->create();

        PublishedArticleRepository::delete($testArticle->id);

        $this->assertDatabaseMissing('article_published', [
            'article_id' => $publishedArticle->getId(),
        ]);
        $this->assertDatabaseMissing('article_details', [
            'article_id' => $publishedArticle->getId(),
            'title' => 'Test title',
        ]);
        $this->assertDatabaseMissing('article_images', [
            'article_id' => $publishedArticle->getId(),
            'image_path' => 'test.jpg'
        ]);
        $this->assertCount(0, ArticleImageEloquent::query()->where('article_id', $publishedArticle->getId())->get());
    }

    public function test_存在しないエンティティをdeleteしたときに何も起こらないこと(): void
    {
        $article_id = Uuid::generate();

        PublishedArticleRepository::delete($article_id);

        $this->assertDatabaseMissing('article_published', [
            'article_id' => $article_id,
        ]);
        $this->assertDatabaseMissing('article_details', [
            'article_id' => $article_id,
        ]);
        $this->assertDatabaseMissing('article_images', [
            'article_id' => $article_id,
        ]);
    }
}
