<?php

declare(strict_types=1);

namespace App\Domain\Article\Entities;

use App\Domain\Article\Collection\ArticleImageList;
use App\Utils\Uuid;

class PublishedArticle
{
    private string $id;

    /**
     * @param string $user_id
     * @param string $title
     * @param string $body
     * @param string $thumbnail_path
     * @param ArticleImageList $images
     * @param string|null $id
     */
    public function __construct(
        private string $user_id,
        private string $title,
        private string $body,
        private string $thumbnail_path,
        private ArticleImageList $images,
        ?string $id = null,
    )
    {
        $this->id = $id ?? Uuid::generate();
        $tmp_images = [];
        foreach ($images->all() as $image) {
            $tmp_images[] = new ArticleImage(
                image_path: $image->getImagePath(),
                user_id: $this->user_id,
                article_id: $this->id,
                id: $image->getId(),
            );
        }
        $this->images = new ArticleImageList($tmp_images);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
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
