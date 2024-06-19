<?php

declare(strict_types=1);

namespace App\Infrastructure\QueryServices;

use App\Http\DTO\CurrentUserDTO;
use App\Models\UserEloquent;

class CurrentUserQueryService
{
    public static function getCurrentUserById(string $id): CurrentUserDTO|null
    {
        $user = UserEloquent::with('userDetailEloquent')->find($id);

        if ($user === null) {
            return null;
        }

        return new CurrentUserDTO(
            id: $user->id,
            display_name: $user->userDetailEloquent->display_name,
            icon_path: $user->userDetailEloquent->icon_path,
        );
    }
}
