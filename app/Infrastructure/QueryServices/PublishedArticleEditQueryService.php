<?php

declare(strict_types=1);

namespace App\Infrastructure\QueryServices;

use App\Http\DTO\PublishedArticleEditPageDTO;
use App\Models\ArticlePublishedEloquent;

class PublishedArticleEditQueryService
{
    public function getPublishedArticleEditDTO(string $articleId): ?PublishedArticleEditPageDTO
    {
        $article = ArticlePublishedEloquent::with(['articleDetailEloquent'])
            ->where('article_id', $articleId)
            ->first();

        if ($article === null) {
            return null;
        }

        return new PublishedArticleEditPageDTO(
            article_id: $article->article_id,
            user_id: $article->user_id,
            title: $article->articleDetailEloquent->title,
            body: $article->articleDetailEloquent->body,
        );
    }
}
