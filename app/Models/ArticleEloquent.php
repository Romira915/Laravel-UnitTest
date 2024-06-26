<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property-read string $id
 * @property-read string $user_id
 * @property-read UserEloquent $userEloquent
 * @property-read ArticlePublishedEloquent $articlePublishedEloquent
 * @property-read ArticleDetailEloquent $articleDetailEloquent
 * @property-read Collection<ArticleImageEloquent> $articleImageEloquent
 * @property-read Collection<ArticleTagsEloquent> $articleTagsEloquent
 */
class ArticleEloquent extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'articles';

    public function userEloquent(): BelongsTo
    {
        return $this->belongsTo(UserEloquent::class, 'user_id');
    }

    public function userDetailEloquent(): BelongsTo
    {
        return $this->belongsTo(UserDetailEloquent::class, 'user_id');
    }

    public function articlePublishedEloquent(): HasOne
    {
        return $this->hasOne(ArticlePublishedEloquent::class, 'article_id');
    }

    public function articleDetailEloquent(): HasOne
    {
        return $this->hasOne(ArticleDetailEloquent::class, 'article_id');
    }

    public function articleImageEloquent(): HasMany
    {
        return $this->hasMany(ArticleImageEloquent::class, 'article_id');
    }

    public function articleTagsEloquent(): HasMany
    {
        return $this->hasMany(ArticleTagsEloquent::class, 'article_id');
    }
}
