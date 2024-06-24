<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\Article\Collection\ArticleImageList;
use App\Domain\Article\Collection\ArticleTagList;
use App\Domain\Article\Entities\ArticleImage;
use App\Domain\Article\Entities\PublishedArticle;
use App\Domain\Article\ValueObject\ArticleTag;
use App\Http\Requests\PostArticlesRequest;
use App\Infrastructure\Persistence\PublishedArticleRepository;

class PostArticlesController extends Controller
{

    public function __construct(private PublishedArticleRepository $publishedArticleRepository)
    {
    }

    public function __invoke(PostArticlesRequest $request)
    {
        $article = new PublishedArticle(
            user_id: $request->current_user_id,
            title: $request->title,
            body: $request->body,
            thumbnail_path: $request->thumbnail_path,
            images: new ArticleImageList(array_map(
                fn($image_path) => new ArticleImage(
                    image_path: $image_path,
                    user_id: $request->current_user_id,
                ),
                $request->image_paths
            )),
            tags: new ArticleTagList(array_map(
                fn($tag_name) => new ArticleTag(
                    user_id: $request->current_user_id,
                    tag_name: $tag_name,
                ),
                $request->tags
            )),
        );

        $this->publishedArticleRepository->save($article);

        return redirect()->action(GetIndexController::class);
    }
}
