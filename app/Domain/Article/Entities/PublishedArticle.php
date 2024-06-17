<?php

declare(strict_types=1);

namespace App\Domain\Article\Entities;


use App\Domain\Article\Collection\ArticleImageList;
use App\Domain\Article\Collection\ArticleTagList;
use Ramsey\Uuid\Uuid;

class PublishedArticle
{
    /**
     * @param string $id
     * @param string $user_id
     * @param string $title
     * @param string $body
     * @param string $thumbnail_path
     * @param ArticleImageList $images
     */
    public function __construct(
        private string           $id,
        private string           $user_id,
        private string           $title,
        private string           $body,
        private string           $thumbnail_path,
        private ArticleImageList $images,
    )
    {
    }

    public static function create(
        string $user_id,
        string $title,
        string $body,
        string $thumbnail_path,
        /** @var string[] $image_paths */
        array $image_paths,
    ): self
    {
        $article_id = (string)Uuid::uuid7();

        return new self(
            id: $article_id,
            user_id: $user_id,
            title: $title,
            body: $body,
            thumbnail_path: $thumbnail_path,
            images: ArticleImageList::fromImagePathList($article_id, $user_id, $image_paths)
        );
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
