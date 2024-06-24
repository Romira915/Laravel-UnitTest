<?php

declare(strict_types=1);

namespace App\Infrastructure\QueryServices;

use App\Http\DTO\TopPagePublishedArticleSummaryDTO;
use App\Models\ArticlePublishedEloquent;

class ArticleSummaryQueryService
{
    /**
     * @param int $limit
     * @return array<TopPagePublishedArticleSummaryDTO>
     */
    public function getArticleSummaryList(int $limit): array
    {
        if ($limit < 1) {
            return [];
        }

        /** @var ArticlePublishedEloquent[] $rows */
        $rows = ArticlePublishedEloquent::with('userDetailEloquent', 'articleDetailEloquent', 'articleTagsEloquent')
            ->limit($limit)
            ->get()
            ->sortByDesc(fn($row) => $row->created_at);

        $result = [];
        foreach ($rows as $row) {
            $result[] = new TopPagePublishedArticleSummaryDTO(
                id: $row->article_id,
                user_id: $row->user_id,
                title: $row->articleDetailEloquent->title,
                body: $row->articleDetailEloquent->body,
                thumbnail_image_path: $row->articleDetailEloquent->thumbnail_path,
                tags: $row->articleTagsEloquent->map(fn($tag) => $tag->tag_name)->toArray(),
                user_display_name: $row->userDetailEloquent->display_name,
                user_icon_path: $row->userDetailEloquent->icon_path,
                created_at: (string)$row->articleDetailEloquent->created_at,
            );
        }

        return $result;
    }
}
