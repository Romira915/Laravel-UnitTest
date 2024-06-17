<?php

declare(strict_types=1);

namespace App\Domain\Article\Entities;

use Ramsey\Uuid\Uuid;

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

    public static function create(string $article_id, string $user_id, string $image_path): ArticleImage
    {
        return new self(
            id: (string)Uuid::uuid7(),
            article_id: $article_id,
            user_id: $user_id,
            image_path: $image_path
        );
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
