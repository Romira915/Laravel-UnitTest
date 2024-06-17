<?php

namespace App\Http\Controllers;

use App\Exception\ArticleNotFoundException;
use App\Infrastructure\QueryServices\PublishedArticleDetailQueryService;
use Illuminate\Http\Request;

class GetArticleDetailController extends Controller
{
    public function __construct(private PublishedArticleDetailQueryService $publishedArticleDetailQueryService)
    {
    }

    public function __invoke(Request $request)
    {
        $article_dto = $this->publishedArticleDetailQueryService->getPublishedArticleDetail($request->article_id);

        if ($article_dto instanceof ArticleNotFoundException) {
            abort(404);
        }

        return view('article_detail', [
            'article' => $article_dto,
            'current_user_dto' => null,
            'is_owner' => false,
        ]);
    }
}
