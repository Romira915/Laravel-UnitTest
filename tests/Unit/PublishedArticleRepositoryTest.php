<?php /** @noinspection NonAsciiCharacters */

namespace Tests\Unit;

use App\Domain\Article\Collection\ArticleImageList;
use App\Domain\Article\Entities\PublishedArticle;
use App\Infrastructure\Persistence\PublishedArticleRepository;
use App\Models\ArticleImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class PublishedArticleRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_存在しないエンティティをsaveしたときに新規に保存されること(): void
    {
        $article_id = Uuid::uuid7();
        $user_id = Uuid::uuid7();

        $publishedArticle = new PublishedArticle(
            id: $article_id,
            user_id: $user_id,
            title: 'Test title',
            body: 'Test body',
            thumbnail_path: 'test.jpg',
            images: new ArticleImageList(
                [
                    new ArticleImage(
                        id: Uuid::uuid7(),
                        article_id: $article_id,
                        user_id: $user_id,
                        image_path: 'test.jpg'
                    ),
                    new ArticleImage(
                        id: Uuid::uuid7(),
                        article_id: $article_id,
                        user_id: $user_id,
                        image_path: 'test2.jpg'
                    )
                ]
            ),
            tags: null
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
    }

    public function test_存在するエンティティをsaveしたときに更新されること(): void
    {
        $article_id = Uuid::uuid7();
        $user_id = Uuid::uuid7();

        $publishedArticle = new PublishedArticle(
            id: $article_id,
            user_id: $user_id,
            title: 'Test title',
            body: 'Test body',
            thumbnail_path: 'test.jpg',
            images: new ArticleImageList(
                [
                    new ArticleImage(
                        id: Uuid::uuid7(),
                        article_id: $article_id,
                        user_id: $user_id,
                        image_path: 'test.jpg'
                    ),
                    new ArticleImage(
                        id: Uuid::uuid7(),
                        article_id: $article_id,
                        user_id: $user_id,
                        image_path: 'test2.jpg'
                    )
                ]
            ),
            tags: null
        );

        PublishedArticleRepository::save($publishedArticle);

        $publishedArticle = new PublishedArticle(
            id: $article_id,
            user_id: $user_id,
            title: 'Updated title',
            body: 'Updated body',
            thumbnail_path: 'test.jpg',
            images: new ArticleImageList(
                [
                    new ArticleImage(
                        id: Uuid::uuid7(),
                        article_id: $article_id,
                        user_id: $user_id,
                        image_path: 'updated.jpg'
                    ),
                    new ArticleImage(
                        id: Uuid::uuid7(),
                        article_id: $article_id,
                        user_id: $user_id,
                        image_path: 'updated2.jpg'
                    )
                ]
            ),
            tags: null
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
    }
}
