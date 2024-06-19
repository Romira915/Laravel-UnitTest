<?php /** @noinspection NonAsciiCharacters */

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\UserDetailEloquent;
use App\Models\UserEloquent;
use App\Models\UserHashedPasswordEloquent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class PostArticlesTest extends TestCase
{
    use RefreshDatabase;

    private UserEloquent $loginUser;

    public function setUp(): void
    {
        parent::setUp();
        $this->loginUser = UserEloquent::factory()->has(UserDetailEloquent::factory())->has(UserHashedPasswordEloquent::factory())->create();
    }

    public function test_正常値のパラメータで記事作成が成功すること(): void
    {
        $this->actingAs($this->loginUser, 'web');

        Storage::fake('public');

        $thumbnail = UploadedFile::fake()->image('thumbnail.jpg');
        $random_title = Str::random(10);
        $images = [
            UploadedFile::fake()->image('image1.jpg'),
            UploadedFile::fake()->image('image2.jpg'),
        ];

        $postArticlesResponse = $this->post('/articles', [
            'title' => $random_title,
            'body' => 'test-body',
            'thumbnail' => $thumbnail,
            'images' => $images,
        ]);

        $postArticlesResponse->assertStatus(302);

        // 作成した記事が表示されていることを確認
        $this->get('/')->assertSee($random_title);
    }

    public function test_タイトルが空のパラメータで記事作成が失敗すること(): void
    {
        $this->actingAs($this->loginUser, 'web');

        Storage::fake('public');

        $thumbnail = UploadedFile::fake()->image('thumbnail.jpg');
        $images = [
            UploadedFile::fake()->image('image1.jpg'),
            UploadedFile::fake()->image('image2.jpg'),
        ];

        $postArticlesResponse = $this->post('/articles', [
            'title' => '',
            'body' => 'test-body',
            'thumbnail' => $thumbnail,
            'images' => $images,
        ]);

        $postArticlesResponse->assertSessionHasErrors(['title']);
    }

    public function test_本文が空のパラメータで記事作成が失敗すること(): void
    {
        $this->actingAs($this->loginUser, 'web');

        Storage::fake('public');

        $thumbnail = UploadedFile::fake()->image('thumbnail.jpg');
        $images = [
            UploadedFile::fake()->image('image1.jpg'),
            UploadedFile::fake()->image('image2.jpg'),
        ];

        $postArticlesResponse = $this->post('/articles', [
            'title' => 'test-title',
            'body' => '',
            'thumbnail' => $thumbnail,
            'images' => $images,
        ]);

        $postArticlesResponse->assertSessionHasErrors(['body']);
    }

    public function test_サムネイルが空のパラメータで記事作成が失敗すること(): void
    {
        $this->actingAs($this->loginUser, 'web');

        Storage::fake('public');

        $images = [
            UploadedFile::fake()->image('image1.jpg'),
            UploadedFile::fake()->image('image2.jpg'),
        ];

        $postArticlesResponse = $this->post('/articles', [
            'title' => 'test-title',
            'body' => 'test-body',
            'thumbnail' => '',
            'images' => $images,
        ]);

        $postArticlesResponse->assertSessionHasErrors(['thumbnail']);
    }

    public function test_サイズがオーバーのサムネイルで記事作成が失敗すること(): void
    {
        $this->actingAs($this->loginUser, 'web');

        Storage::fake('public');

        $thumbnail = UploadedFile::fake()->image('thumbnail.jpg')->size(5000);
        $images = [
            UploadedFile::fake()->image('image1.jpg'),
            UploadedFile::fake()->image('image2.jpg'),
        ];

        $postArticlesResponse = $this->post('/articles', [
            'title' => 'test-title',
            'body' => 'test-body',
            'thumbnail' => $thumbnail,
            'images' => $images,
        ]);

        $postArticlesResponse->assertSessionHasErrors(['thumbnail']);
    }

    public function test_サイズがオーバーの画像で記事作成が失敗すること(): void
    {
        $this->actingAs($this->loginUser, 'web');

        Storage::fake('public');

        $thumbnail = UploadedFile::fake()->image('thumbnail.jpg');
        $images = [
            UploadedFile::fake()->image('image1.jpg')->size(5000),
            UploadedFile::fake()->image('image2.jpg'),
        ];

        $postArticlesResponse = $this->post('/articles', [
            'title' => 'test-title',
            'body' => 'test-body',
            'thumbnail' => $thumbnail,
            'images' => $images,
        ]);

        $postArticlesResponse->assertSessionHasErrors(['images.0']);
    }

    public function test_未ログインでリクエストするとログイン画面にリダイレクトされること(): void
    {
        Storage::fake('public');

        $thumbnail = UploadedFile::fake()->image('thumbnail.jpg');
        $images = [
            UploadedFile::fake()->image('image1.jpg'),
            UploadedFile::fake()->image('image2.jpg'),
        ];

        $postArticlesResponse = $this->post('/articles', [
            'title' => 'test-title',
            'body' => 'test-body',
            'thumbnail' => $thumbnail,
            'images' => $images,
        ]);

        $postArticlesResponse->assertStatus(302);
        $postArticlesResponse->assertRedirect('/auth/login');
    }
}
