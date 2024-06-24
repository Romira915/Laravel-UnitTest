<?php

declare(strict_types=1);

namespace App\Http\DTO;

readonly class TopPagePublishedArticleSummaryDTO
{
    public string $thumbnail_url;

    public function __construct(
        public string $id,
        public string $user_id,
        public string $title,
        public string $body,
        string $thumbnail_image_path,
        /** @var array<string> */
        public array $tags,
        public string $user_display_name,
        public string $user_icon_path,
        public string $created_at,
    )
    {
        $this->thumbnail_url = config('image.base_url') . $thumbnail_image_path;
    }
}
