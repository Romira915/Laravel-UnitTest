<?php

declare(strict_types=1);

namespace App\Domain\Article\Entities;

readonly class ArticleImage
{
    public function __construct(
        private string $id,
        private string $article_id,
        private string $user_id,
        private string $image_path,
    )
    {
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
