<?php

namespace App\Http\Requests\Trait;

use App\Http\DTO\CurrentUserDTO;
use App\Infrastructure\QueryServices\CurrentUserQueryService;
use Illuminate\Support\Facades\Auth;

trait CurrentUserTrait
{
    public function getCurrentUserDto(CurrentUserQueryService $currentUserQueryService): CurrentUserDTO|null
    {
        if (Auth::check()) {
            return $currentUserQueryService->getCurrentUserById(Auth::id());
        } else {
            return null;
        }
    }
}
