<?php

declare(strict_types=1);

namespace App\Domain\Article\ValueObject;

use App\Domain\Validator\TagValidator;
use App\Utils\Uuid;

readonly class ArticleTag
{
    public string $id;
    public  string $tag_name;

    public function __construct(
        public  string $user_id,
        string $tag_name,
        public  ?string $article_id = null,
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
}
