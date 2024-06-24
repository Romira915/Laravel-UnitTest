<?php

declare(strict_types=1);

namespace App\Domain\Article\Entities;

use App\Domain\Validator\TagValidator;
use App\Utils\Uuid;

readonly class ArticleTag
{
    private string $id;
    private string $tag_name;

    public function __construct(
        private string $user_id,
        string $tag_name,
        private ?string $article_id = null,
        ?string $id = null,
    )
    {
        if ($id === null) {
            $this->id = Uuid::generate();
        } else {
            $this->id = $id;
        }

        if (!TagValidator::validate($tag_name)) {
            throw new \InvalidArgumentException('Invalid tag name');
        }
        $this->tag_name = $tag_name;
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

    public function getTag(): string
    {
        return $this->tag_name;
    }
}
