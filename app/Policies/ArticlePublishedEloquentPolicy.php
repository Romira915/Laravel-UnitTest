<?php

namespace App\Policies;

use App\Models\ArticlePublishedEloquent;
use App\Models\UserEloquent;

class ArticlePublishedEloquentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserEloquent $userEloquent): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserEloquent $userEloquent, ArticlePublishedEloquent $articlePublishedEloquent): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserEloquent $userEloquent): bool
    {
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserEloquent $userEloquent, ArticlePublishedEloquent $articlePublishedEloquent): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserEloquent $userEloquent, ArticlePublishedEloquent $articlePublishedEloquent): bool
    {
        return $userEloquent->id === $articlePublishedEloquent->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserEloquent $userEloquent, ArticlePublishedEloquent $articlePublishedEloquent): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserEloquent $userEloquent, ArticlePublishedEloquent $articlePublishedEloquent): bool
    {
        //
    }
}
