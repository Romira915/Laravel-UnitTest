<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\Article\Collection\ArticleImageList;
use App\Domain\Article\Entities\ArticleImage;
use App\Domain\Article\Entities\PublishedArticle;
use App\Http\Requests\PostArticlesRequest;
use App\Infrastructure\Persistence\PublishedArticleRepository;
use Ramsey\Uuid\Uuid;

class PostArticlesController extends Controller
{

    public function __construct(private PublishedArticleRepository $publishedArticleRepository)
    {
    }

    public function __invoke(PostArticlesRequest $request)
    {
        $thumbnail_path = '/storage/' . $request->file('thumbnail')->storePublicly('images/thumbnails', 'public');
        $image_paths = [];
        foreach ($request->file('images') as $image) {
            $image_paths[] = '/storage/' . $image->storePublicly('images/articles', 'public');
        }

        $article_id = (string)Uuid::uuid7();
        $user_id = (string)Uuid::uuid7(); /** TODO: ログイン機能実装後に置き換える */

        $images = [];
        foreach ($image_paths as $image_path) {
            $images[] = new ArticleImage(
                id: (string)Uuid::uuid7(),
                article_id: $article_id,
                user_id: $user_id,
                image_path: $image_path
            );
        }

        $article = new PublishedArticle(
            id:$article_id,
            user_id: $user_id,
            title: $request->title,
            body: $request->body,
            thumbnail_path: $thumbnail_path,
            images: new ArticleImageList($images)
        );

        $this->publishedArticleRepository->save($article);

        return redirect()->action(GetIndexController::class);
    }
}
