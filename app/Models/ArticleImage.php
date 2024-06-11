<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleImage extends Model
{
    use HasFactory, HasUuids;

    public function __construct(
        private readonly string $id = '',
        private readonly string $article_id = '',
        private readonly string $user_id = '',
        private readonly string $image_path = '',
    )
    {
        parent::__construct();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getArticleId(): string
    {
        return $this->article_id;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function getImagePath(): string
    {
        return $this->image_path;
    }
}
