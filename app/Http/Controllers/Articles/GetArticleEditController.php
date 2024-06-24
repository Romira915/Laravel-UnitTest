<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use App\Infrastructure\QueryServices\PublishedArticleEditQueryService;
use App\Models\ArticlePublishedEloquent;
use Illuminate\Http\Request;

class GetArticleEditController extends Controller
{
    public function __construct(private PublishedArticleEditQueryService $publishedArticleEditQueryService)
    {
    }

    public function __invoke(Request $request, string $article_id)
    {
        $current_user = $request->user();

        if ($current_user->cannot('update', ArticlePublishedEloquent::query()->find($article_id))) {
            abort(403);
        }

        $article_edit_dto = $this->publishedArticleEditQueryService->getPublishedArticleEditDTO($article_id);
        if ($article_edit_dto === null) {
            abort(404);
        }

        return view('article_edit', [
            'current_user_id' => $current_user->id,
            'current_user_display_name' => $current_user->userDetailEloquent->display_name,
            'current_user_icon_path' => $current_user->userDetailEloquent->icon_path,
            'article_edit_dto' => $article_edit_dto,
        ]);
    }
}
