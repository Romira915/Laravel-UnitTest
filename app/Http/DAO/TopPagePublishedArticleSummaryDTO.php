<?php

declare(strict_types=1);

namespace App\Http\DAO;

class TopPagePublishedArticleSummaryDTO
{
    public string $thumbnail_url;

    public function __construct(
        public string $id,
        public string $title,
        public string $body,
        string $thumbnail_image_path,
        public string $created_at,
    )
    {
        $this->thumbnail_url = config('image.base_url') . $thumbnail_image_path;
    }
}
