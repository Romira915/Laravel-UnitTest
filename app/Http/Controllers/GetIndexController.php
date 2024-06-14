<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\GetIndexRequest;
use App\Infrastructure\QueryServices\ArticleSummaryQueryService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class GetIndexController extends Controller
{
    const int DEFAULT_LIMIT = 20;

    public function __construct(
        private ArticleSummaryQueryService $articleSummaryQueryService
    )
    {
    }

    public function __invoke(GetIndexRequest $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $articles = $this->articleSummaryQueryService->getArticleSummaryList($request->limit ? (int)$request->limit : self::DEFAULT_LIMIT);

        return view('index', [
            'currentUserDTO' => null /** TODO */,
            'errorMessage' => "Error" /** TODO */,
            'articles' => $articles,
        ]);
    }
}
