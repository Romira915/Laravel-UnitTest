<?php

declare(strict_types=1);

namespace App\Domain\Article\Entities;

use App\Utils\Uuid;

readonly class ArticleImage
{
    private string $id;

    public function __construct(
        private string $article_id,
        private string $user_id,
        private string $image_path,
        ?string $id = null,
    )
    {
        $this->id = $id ?? Uuid::generate();
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
