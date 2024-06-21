<?php

declare(strict_types=1);

namespace App\Http\Controllers\Articles\PostArticles;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GetIndexController;
use App\Infrastructure\Persistence\PublishedArticleRepository;
use App\Models\ArticlePublishedEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostArticleIdDeleteController extends Controller
{
    public function __construct(private PublishedArticleRepository $publishedArticleRepository)
    {
    }

    public function __invoke(Request $request, string $article_id)
    {
        if ($request->user()->cannot('delete', ArticlePublishedEloquent::query()->find($article_id))) {
            abort(403);
        }

        DB::transaction(function () use ($article_id) {
            $this->publishedArticleRepository->delete($article_id);
        });

        return redirect()->action(GetIndexController::class);
    }
}
