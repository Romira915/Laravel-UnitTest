<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\GetIndexRequest;
use App\Infrastructure\QueryServices\ArticleSummaryQueryService;
use App\Infrastructure\QueryServices\CurrentUserQueryService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class GetIndexController extends Controller
{
    const int DEFAULT_LIMIT = 20;

    public function __construct(
        private ArticleSummaryQueryService $articleSummaryQueryService,
        private CurrentUserQueryService $currentUserServiceQuery,
    )
    {
    }

    public function __invoke(GetIndexRequest $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        if (Auth::check()) {
            $current_user_dto = $this->currentUserServiceQuery->getCurrentUserById(Auth::id());
        } else {
            $current_user_dto = null;
        }

        $articles = $this->articleSummaryQueryService->getArticleSummaryList($request->limit ? (int)$request->limit : self::DEFAULT_LIMIT);

        return view('index', [
            'current_user_dto' => $current_user_dto,
            'articles' => $articles,
        ]);
    }
}
