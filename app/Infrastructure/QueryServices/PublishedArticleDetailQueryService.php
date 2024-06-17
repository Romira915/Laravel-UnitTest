<?php

declare(strict_types=1);

namespace App\Infrastructure\QueryServices;

use App\Exception\ArticleNotFoundException;
use App\Http\DTO\PublishedArticleDetailPageDTO;
use App\Models\ArticleEloquent;

class PublishedArticleDetailQueryService
{
    public function getPublishedArticleDetail(string $article_id): PublishedArticleDetailPageDTO|null
    {
        $article = ArticleEloquent::with('articleDetailEloquent', 'articlePublishedEloquent', 'articleImageEloquent')
            ->where('id', $article_id)
            ->first();

        if ($article === null) {
            return null;
        }

        $image_path_list = [];
        foreach ($article->ArticleImageEloquent as $image) {
            $image_path_list[] = config('image.base_url') . $image->image_path;
        }

        return new PublishedArticleDetailPageDTO(
            article_id: $article->id,
            user_id: $article->user_id,
            title: $article->articleDetailEloquent->title,
            body: $article->articleDetailEloquent->body,
            thumbnail_image_url: config('image.base_url') . $article->articleDetailEloquent->thumbnail_path,
            image_url_list: $image_path_list,
            tags: [] /* TODO: Implement tags */,
            created_at: (string)$article->articlePublishedEloquent->created_at,
            updated_at: (string)$article->articlePublishedEloquent->updated_at,
        );
    }
}
