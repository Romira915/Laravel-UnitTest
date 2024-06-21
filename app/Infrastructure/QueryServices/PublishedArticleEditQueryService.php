<?php

declare(strict_types=1);

namespace App\Infrastructure\QueryServices;

use App\Http\DTO\PublishedArticleEditPageDTO;
use App\Models\ArticleEloquent;

class PublishedArticleEditQueryService
{
    public function getPublishedArticleEditDTO(string $articleId): PublishedArticleEditPageDTO
    {
        $article = ArticleEloquent::with(['articlePublishedEloquent', 'articleDetailEloquent'])
            ->where('id', $articleId)
            ->get()
            ->filter(fn($row) => $row->articlePublishedEloquent !== null && $row->articleDetailEloquent !== null)
            ->first();

        if ($article === null) {
            throw new \RuntimeException('Article not found');
        }

        return new PublishedArticleEditPageDTO(
            article_id: $article->id,
            user_id: $article->user_id,
            title: $article->articleDetailEloquent->title,
            body: $article->articleDetailEloquent->body,
        );
    }
}
