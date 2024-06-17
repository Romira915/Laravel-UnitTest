<?php

declare(strict_types=1);

namespace App\Http\Controllers;

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
        /** TODO: ログイン機能実装後に置き換える */
        $user_id = (string)Uuid::uuid7();

        $article = PublishedArticle::create(
            user_id: $user_id,
            title: $request->title,
            body: $request->body,
            thumbnail_path: $request->thumbnail_path,
            image_paths: $request->image_paths
        );

        $this->publishedArticleRepository->save($article);

        return redirect()->action(GetIndexController::class);
    }
}
