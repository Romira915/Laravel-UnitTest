<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Article extends Model
{
    use HasFactory, HasUuids;

    public function articlePublished(): HasOne
    {
        return $this->hasOne(ArticlePublished::class);
    }

    public function articleDetail(): HasOne
    {
        return $this->hasOne(ArticleDetail::class);
    }
}
