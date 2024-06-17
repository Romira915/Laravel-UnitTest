<?php

declare(strict_types=1);

namespace App\Infrastructure\QueryServices;

use App\Http\DAO\PublishedArticleDetailPageDTO;

class PublishedArticleDetailQueryService
{
    public function getPublishedArticleDetail(string $articleId): PublishedArticleDetailPageDTO
    {
        $article = ArticleEloquent::with('articleDetailEloquent', 'articlePublishedEloquent', 'articleTagEloquent', 'articleImageEloquent')
            ->where('id', $articleId)
            ->first();

        if ($article === null) {
            throw new ArticleNotFoundException();
        }

        $imageList = new ArticleImageList(
            $article->articleImageEloquent->map(fn($image) => new ArticleImage(
                id: $image->id,
                url: config('image.base_url') . $image->path,
            ))->toArray()
        );

        $tagList = new ArticleTagList(
            $article->articleTagEloquent->map(fn($tag) => new ArticleTag(
                id: $tag->id,
                name: $tag->name,
            ))->toArray()
        );

        return new PublishedArticleDetailPageDTO(
            article_id: $article->id,
            user_id: $article->user_id,
            title: $article->articleDetailEloquent->title,
            body: $article->articleDetailEloquent->body,
            thumbnail_image_url: config('image.base_url') . $article->articleDetailEloquent->thumbnail_path,
            image_url_list: $imageList->getImageUrlList(),
            tags: $tagList->getTagList(),
            created_at: (string)$article->articlePublishedEloquent->created_at,
            updated_at: (string)$article->articlePublishedEloquent->updated_at,
        );
    }
}
