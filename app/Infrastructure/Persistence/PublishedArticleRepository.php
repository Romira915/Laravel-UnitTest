<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Article\Entities\PublishedArticle;
use App\Models\Article;
use App\Models\ArticleDetail;
use App\Models\ArticleImage;
use App\Models\ArticlePublished;

class PublishedArticleRepository
{
    public static function save(PublishedArticle $article): void
    {
        Article::query()->upsert([
            'id' => $article->getId(),
            'user_id' => $article->getUserId(),
        ], ['id'], ['id', 'user_id']);

        ArticlePublished::query()->upsert([
            'article_id' => $article->getId(),
            'user_id' => $article->getUserId(),
        ], ['article_id']);

        ArticleDetail::query()->upsert([
            'article_id' => $article->getId(),
            'user_id' => $article->getUserId(),
            'title' => $article->getTitle(),
            'body' => $article->getBody(),
        ], ['article_id'], ['article_id', 'title', 'body']);

        ArticleImage::query()->where('article_id', $article->getId())->delete();
        foreach ($article->getImages()->all() as $image) {
            ArticleImage::query()->upsert([
                'id' => $image->getId(),
                'article_id' => $article->getId(),
                'user_id' => $article->getUserId(),
                'image_path' => $image->getImagePath(),
            ], ['id']);
        }
    }
}
