<?php

declare(strict_types=1);

namespace App\Http\DTO;

readonly class PublishedArticleDetailPageDTO
{
    public function __construct(
        public string $article_id,
        public string $user_id,
        public string $title,
        public string $body,
        public string $thumbnail_image_url,
        /** @var array<string> */
        public array $image_url_list,
        /** @var array<string> */
        public array $tags,
        public string $created_at,
        public string $updated_at,
    )
    {
    }
}
