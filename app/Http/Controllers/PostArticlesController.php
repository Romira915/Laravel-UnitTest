<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\Article\Collection\ArticleImageList;
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
        $thumbnail_path = '/storage/' . $request->file('thumbnail')->storePublicly('image/thumbnails', 'public');

        $article = new PublishedArticle(
            id: (string)Uuid::uuid7(),
            user_id: (string)Uuid::uuid7(), /** TODO: ログイン機能実装後に置き換える */
            title: $request->title,
            body: $request->body,
            thumbnail_path: $thumbnail_path,
            images: new ArticleImageList([])
        );

        $this->publishedArticleRepository->save($article);

        return redirect()->action(GetIndexController::class);
    }
}
