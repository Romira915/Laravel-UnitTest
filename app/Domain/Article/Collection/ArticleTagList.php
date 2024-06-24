<?php

declare(strict_types=1);

namespace App\Domain\Article\Collection;

use App\Domain\Article\Entities\ArticleTag;

class ArticleTagList
{
    const int MAX_TAGS = 10;

    /** @var ArticleTag[] */
    private array $tags = [];

    /**
     * @param ArticleTag[] $tags
     * @throws \InvalidArgumentException
     */
    public function __construct(
        array $tags = []
    )
    {
        if (count($tags) > self::MAX_TAGS) {
            throw new \InvalidArgumentException('The maximum number of tags is ' . self::MAX_TAGS);
        }

        // duplicate check
        $tagNames = array_map(fn($tag) => $tag->getTag(), $tags);
        if (count($tagNames) !== count(array_unique($tagNames))) {
            throw new \InvalidArgumentException('Duplicate tags are not allowed');
        }

        $this->tags = $tags;
    }

    /**
     * @return ArticleTag[]
     */
    public function all(): array
    {
        return $this->tags;
    }
}
