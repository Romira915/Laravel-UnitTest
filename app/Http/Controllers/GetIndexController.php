<?php

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
        protected ArticleSummaryQueryService $articleSummaryQueryService
    )
    {
    }

    /**
     * @param GetIndexRequest $request
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(GetIndexRequest $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $articles = $this->articleSummaryQueryService->getArticleSummaryList($request->limit ?? self::DEFAULT_LIMIT);

        return view('index', [
            'currentUserDTO' => null /** TODO */,
            'errorMessage' => "Error" /** TODO */,
            'articles' => $articles,
        ]);
    }
}
