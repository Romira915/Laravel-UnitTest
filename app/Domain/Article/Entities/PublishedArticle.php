<?php

declare(strict_types=1);

namespace App\Domain\Article\Entities;

use App\Domain\Article\Collection\ArticleImageList;
use App\Utils\Uuid;

class PublishedArticle
{
    private string $id;
    private ArticleImageList $images;

    /**
     * @param string $id
     * @param string $user_id
     * @param string $title
     * @param string $body
     * @param string $thumbnail_path
     * @param ArticleImageList $images
     */
    public function __construct(
        private string $user_id,
        private string $title,
        private string $body,
        private string $thumbnail_path,
        /** @var string[] $image_paths */
        array $image_paths,
        ?string $id = null,
    )
    {
        $this->id = $id ?? Uuid::generate();
        $this->images = ArticleImageList::fromImagePathList($this->id, $user_id, $image_paths);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getThumbnailPath(): string
    {
        return $this->thumbnail_path;
    }

    public function getImages(): ArticleImageList
    {
        return $this->images;
    }

    public function getTags(): ArticleTagList
    {
        return $this->tags;
    }
}
