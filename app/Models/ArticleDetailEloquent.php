<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleDetailEloquent extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'article_details';
    protected $primaryKey = 'article_id';
}
