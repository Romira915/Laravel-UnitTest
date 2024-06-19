<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Infrastructure\QueryServices\PublishedArticleDetailQueryService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class GetArticlesArticleIdController extends Controller
{
    public function __construct(private PublishedArticleDetailQueryService $publishedArticleDetailQueryService)
    {
    }

    public function __invoke(Request $request)
    {
        $article_dto = $this->publishedArticleDetailQueryService->getPublishedArticleDetail($request->article_id);

        if ($article_dto === null) {
            abort(404);
        }

        return view('article_detail', [
            'article' => $article_dto,
            'current_user_id' => $request->current_user_id,
            'current_user_display_name' => $request->current_user_display_name,
            'current_user_icon_path' => $request->current_user_icon_path,
            'is_owner' => false,
        ]);
    }
}
