<?php

declare(strict_types=1);

namespace App\Http\DTO;

readonly class PublishedArticleEditPageDTO
{
    public function __construct(
        public string $article_id,
        public string $user_id,
        public string $title,
        public string $body,
    )
    {
    }
}
