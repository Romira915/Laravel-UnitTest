<?php

declare(strict_types=1);

namespace App\Http\Controllers\Articles\PostArticles;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GetIndexController;
use App\Infrastructure\Persistence\PublishedArticleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostArticleIdDeleteController extends Controller
{
    public function __construct(private PublishedArticleRepository $publishedArticleRepository)
    {
    }

    public function __invoke(Request $request, string $article_id)
    {
        DB::transaction(function () use ($article_id) {
            $this->publishedArticleRepository->delete($article_id);
        });

        return redirect()->action(GetIndexController::class);
    }
}
