<?php

declare(strict_types=1);

namespace App\Domain\Article\Collection;

use App\Domain\Article\Entities\ArticleImage;
use InvalidArgumentException;

class ArticleImageList
{
    const int MAX_IMAGES = 20;

    /** @var ArticleImage[] */
    private array $images = [];

    /**
     * @param ArticleImage[] $images
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

    public static function fromImagePathList(string $article_id, string $user_id, array $image_paths): ArticleImageList
    {
        $imageList = [];
        foreach ($image_paths as $image_path) {
            $imageList[] = ArticleImage::create($article_id, $user_id, $image_path);
        }
        return new self($imageList);
    }

    /**
     * @return ArticleImage[]
     */
    public function all(): array
    {
        return $this->images;
    }
}
