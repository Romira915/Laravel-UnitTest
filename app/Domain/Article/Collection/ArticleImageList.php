<?php

declare(strict_types=1);

namespace App\Domain\Article\Collection;

use App\Domain\Article\Entities\DomainArticleImage;
use InvalidArgumentException;

class ArticleImageList
{
    const int MAX_IMAGES = 20;

    /** @var DomainArticleImage[] */
    private array $images = [];

    /**
     * @param DomainArticleImage[] $images
     * @throws InvalidArgumentException
     */
    public function __construct(
        array $images = []
    )
    {
        if (count($images) > self::MAX_IMAGES) {
            throw new InvalidArgumentException('The maximum number of images is ' . self::MAX_IMAGES);
        }

        $this->images = $images;
    }

    /**
     * @return DomainArticleImage[]
     */
    public function all(): array
    {
        return $this->images;
    }
}
