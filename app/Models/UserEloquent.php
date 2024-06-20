<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property-read string $id
 * @property-read UserDetailEloquent $userDetailEloquent
 * @property-read UserHashedPasswordEloquent $userHashedPasswordEloquent
 */
class UserEloquent extends Authenticatable
{
    use HasFactory, HasUuids;

    protected $table = 'users';

    protected $fillable = ['id'];

    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    public function getAuthIdentifier(): string
    {
        return $this->id;
    }

    public function getAuthPassword()
    {
        return $this->userHashedPasswordEloquent->hashed_password;
    }

    public function userDetailEloquent(): HasOne
    {
        return $this->hasOne(UserDetailEloquent::class, 'user_id');
    }

    public function userHashedPasswordEloquent(): HasOne
    {
        return $this->hasOne(UserHashedPasswordEloquent::class, 'user_id');
    }

    public function articlesEloquent()
    {
        return $this->hasMany(ArticleEloquent::class, 'user_id');
    }
}
