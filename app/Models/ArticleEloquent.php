<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ArticleEloquent extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'articles';

    public function articlePublishedEloquent(): HasOne
    {
        return $this->hasOne(ArticlePublishedEloquent::class, 'article_id');
    }

    public function articleDetailEloquent(): HasOne
    {
        return $this->hasOne(ArticleDetailEloquent::class, 'article_id');
    }

    public function articleImageEloquent(): HasOne
    {
        return $this->hasOne(ArticleImageEloquent::class, 'article_id');
    }
}
