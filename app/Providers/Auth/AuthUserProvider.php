<?php

declare(strict_types=1);

namespace App\Providers\Auth;

use App\Models\UserEloquent;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class AuthUserProvider extends EloquentUserProvider implements UserProvider
{
    public function __construct()
    {
        parent::__construct(app('hash'), UserEloquent::class);
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    public function retrieveById($identifier): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|Authenticatable|null
    {
        return UserEloquent::query()->find($identifier);
    }

    public function retrieveByCredentials(array $credentials): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|Authenticatable|null
    {
        return UserEloquent::with('userHashedPasswordEloquent', 'userDetailEloquent')->whereRelation('userDetailEloquent', 'display_name', $credentials['display_name'])->first();
    }

    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        if (is_null($plain = $credentials['password'])) {
            return false;
        }

        return $this->hasher->check($plain, $user->getAuthPassword());
    }

    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false)
    {
    }
}
