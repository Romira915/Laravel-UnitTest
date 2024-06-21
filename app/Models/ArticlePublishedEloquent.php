<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property-read string $article_id
 * @property-read ArticleDetailEloquent $articleDetailEloquent
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
}
