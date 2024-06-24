<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GetArticlesArticleIdController;
use App\Http\Requests\PostArticleEditRequest;
use App\Infrastructure\Persistence\PublishedArticleRepository;
use App\Models\ArticlePublishedEloquent;

class PostArticleEditController extends Controller
{
    public function __construct(private PublishedArticleRepository $publishedArticleRepository)
    {
    }

    public function __invoke(PostArticleEditRequest $request, string $article_id)
    {
        $current_user = $request->user();

        if ($current_user->cannot('update', ArticlePublishedEloquent::query()->where('article_id', $article_id)->first())) {
            abort(403);
        }

        $article = $this->publishedArticleRepository->findById($article_id);
        if ($article === null) {
            abort(404);
        }

        $article->setTitle($request->title);
        $article->setBody($request->body);
        $this->publishedArticleRepository->save($article);

        return redirect()->action(GetArticlesArticleIdController::class, ['article_id' => $article_id]);
    }
}
