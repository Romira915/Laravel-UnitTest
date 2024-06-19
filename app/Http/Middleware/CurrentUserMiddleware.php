<?php

namespace App\Http\Middleware;

use App\Infrastructure\QueryServices\CurrentUserQueryService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CurrentUserMiddleware
{
    public function __construct(
        private CurrentUserQueryService $currentUserQueryService
    ) {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $current_user_dto = $this->currentUserQueryService->getCurrentUserById(Auth::id());
            $request->merge([
                'current_user_dto' => [$current_user_dto]
            ]);
        } else {
            $request->merge([
                'current_user_dto' => [null]
            ]);
        }

        return $next($request);
    }
}
