<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticlePublishedEloquent extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'article_published';
    protected $primaryKey = 'article_id';
}
