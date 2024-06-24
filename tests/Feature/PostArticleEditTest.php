<?php /** @noinspection NonAsciiCharacters */

namespace Tests\Feature;

use App\Models\ArticleDetailEloquent;
use App\Models\ArticleEloquent;
use App\Models\ArticlePublishedEloquent;
use App\Models\UserDetailEloquent;
use App\Models\UserEloquent;
use App\Models\UserHashedPasswordEloquent;
use Tests\TestCase;

class PostArticleEditTest extends TestCase
{
    /**
     * @throws \JsonException
     */
    public function test_投稿したユーザーで記事編集に成功すること(): void
    {
        $loginUser = UserEloquent::factory()
            ->has(UserDetailEloquent::factory())
            ->has(UserHashedPasswordEloquent::factory())
            ->create();

        $article = ArticleEloquent::factory()
            ->state(['user_id' => $loginUser->id])
            ->has(ArticlePublishedEloquent::factory()->state(['user_id' => $loginUser->id]))
            ->has(ArticleDetailEloquent::factory()->state(['user_id' => $loginUser->id]))
            ->create();

        $response = $this->actingAs($loginUser, 'web')->post('/articles/' . $article->id . '/edit', [
            'title' => 'Test title',
            'body' => 'Test body',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/articles/' . $article->id);
    }

    public function test_他のユーザーで記事編集に失敗すること(): void
    {
        $random_user_id = UserEloquent::query()->inRandomOrder()->first()->id;

        $loginUser = UserEloquent::factory()
            ->has(UserDetailEloquent::factory())
            ->has(UserHashedPasswordEloquent::factory())
            ->create();

        $article = ArticleEloquent::factory()
            ->state(['user_id' => $random_user_id])
            ->has(ArticlePublishedEloquent::factory()->state(['user_id' => $random_user_id]))
            ->has(ArticleDetailEloquent::factory()->state(['user_id' => $random_user_id]))
            ->create();

        $response = $this->actingAs($loginUser, 'web')->post('/articles/' . $article->id . '/edit', [
            'title' => 'Test title',
            'body' => 'Test body',
        ]);

        $response->assertStatus(403);
    }

    public function test_未ログインで記事編集はできず、ログイン画面にリダイレクトされること(): void
    {
        $random_user_id = UserEloquent::query()->inRandomOrder()->first()->id;
        $article = ArticleEloquent::factory()
            ->state(['user_id' => $random_user_id])
            ->has(ArticlePublishedEloquent::factory()->state(['user_id' => $random_user_id]))
            ->has(ArticleDetailEloquent::factory()->state(['user_id' => $random_user_id]))
            ->create();

        $response = $this->post('/articles/' . $article->id . '/edit', [
            'title' => 'Test title',
            'body' => 'Test body',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/auth/login');
    }
}
