<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property-read string $article_id
 * @property-read string $user_id
 * @property-read string $image_path
 * @property-read ArticleDetailEloquent $articleDetailEloquent
 * @property-read Collection<ArticleImageEloquent> $articleImageEloquent
 * @property-read Collection<ArticleTagsEloquent> $articleTagsEloquent
 */
class ArticlePublishedEloquent extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'article_published';
    protected $primaryKey = 'article_id';

    public function articleDetailEloquent(): HasOne
    {
        return $this->hasOne(ArticleDetailEloquent::class, 'article_id', 'article_id');
    }

    public function articleImageEloquent(): HasMany
    {
        return $this->hasMany(ArticleImageEloquent::class, 'article_id', 'article_id');
    }

    public function articleTagsEloquent(): HasMany
    {
        return $this->hasMany(ArticleTagsEloquent::class, 'article_id', 'article_id');
    }
}
