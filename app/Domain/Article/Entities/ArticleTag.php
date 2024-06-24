<?php

declare(strict_types=1);

namespace App\Domain\Article\Entities;

use App\Domain\Validator\TagValidator;
use App\Utils\Uuid;

class ArticleTag
{
    public function __construct(
        private string $user_id,
        private string $tag_name,
        private ?string $id = null,
        private ?string $article_id = null,
    )
    {
        if ($this->id === null) {
            $this->id = Uuid::generate();
        }
        $this->setTag($tag_name);
    }

    public function getId(): string|null
    {
        return $this->id;
    }

    public function getArticleId(): string|null
    {
        return $this->article_id;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    private function setTag(string $tag_name): void
    {
        if (!TagValidator::validate($tag_name)) {
            throw new \InvalidArgumentException('Invalid tag name');
        }

        $this->tag_name = $tag_name;
    }


    public function getTag(): string
    {
        return $this->tag_name;
    }
}
