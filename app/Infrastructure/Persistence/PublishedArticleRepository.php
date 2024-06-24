<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Article\Collection\ArticleImageList;
use App\Domain\Article\Entities\ArticleImage;
use App\Domain\Article\Entities\PublishedArticle;
use App\Models\ArticleDetailEloquent;
use App\Models\ArticleEloquent;
use App\Models\ArticleImageEloquent;
use App\Models\ArticlePublishedEloquent;
use App\Models\ArticleTagsEloquent;

class PublishedArticleRepository
{
    public static function findById(string $id): ?PublishedArticle
    {
        /** @var ArticlePublishedEloquent $article */
        $article = ArticlePublishedEloquent::with('articleDetailEloquent', 'articleImageEloquent')->where('article_id', $id)->first();

        if ($article === null) {
            return null;
        }

        return new PublishedArticle(
            user_id: $article->user_id,
            title: $article->articleDetailEloquent->title,
            body: $article->articleDetailEloquent->body,
            thumbnail_path: $article->articleDetailEloquent->thumbnail_path,
            images: new ArticleImageList(array_map(
                fn($image) => new ArticleImage(
                    image_path: $image->image_path,
                    user_id: $article->user_id,
                    id: $image->id
                ),
                $article->articleImageEloquent->all()
            )),
            id: $article->article_id
        );
    }

    public static function save(PublishedArticle $article): void
    {
        ArticleEloquent::query()->upsert([
            'id' => $article->getId(),
            'user_id' => $article->getUserId(),
        ], ['id'], ['id', 'user_id']);

        ArticlePublishedEloquent::query()->upsert([
            'article_id' => $article->getId(),
            'user_id' => $article->getUserId(),
        ], ['article_id'], ['article_id', 'user_id']);

        ArticleDetailEloquent::query()->upsert([
            'article_id' => $article->getId(),
            'user_id' => $article->getUserId(),
            'title' => $article->getTitle(),
            'body' => $article->getBody(),
            'thumbnail_path' => $article->getThumbnailPath(),
        ], ['article_id'], ['article_id', 'user_id', 'title', 'body']);

        ArticleImageEloquent::query()->where('article_id', $article->getId())->delete();
        $upsertValues = [];
        foreach ($article->getImages()->all() as $image) {
            $upsertValues[] = [
                'id' => $image->getId(),
                'article_id' => $article->getId(),
                'user_id' => $article->getUserId(),
                'image_path' => $image->getImagePath(),
            ];
        }
        ArticleImageEloquent::query()->upsert($upsertValues, ['id'], ['id', 'article_id', 'user_id', 'image_path']);

        ArticleTagsEloquent::query()->where('article_id', $article->getId())->delete();
        $insertValues = [];
        foreach ($article->getTags()->all() as $tag) {
            $insertValues[] = [
                'id' => $tag->getId(),
                'article_id' => $article->getId(),
                'user_id' => $article->getUserId(),
                'tag_name' => $tag->getTag(),
            ];
        }
        ArticleTagsEloquent::query()->insert($insertValues);
    }

    public static function delete(string $article_id): void
    {
        ArticleImageEloquent::query()->where('article_id', $article_id)->delete();
        ArticleDetailEloquent::query()->where('article_id', $article_id)->delete();
        ArticlePublishedEloquent::query()->where('article_id', $article_id)->delete();
    }
}
