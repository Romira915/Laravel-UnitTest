<?php

declare(strict_types=1);

namespace App\Infrastructure\QueryServices;

use App\Http\DTO\TopPagePublishedArticleSummaryDTO;
use App\Models\ArticleEloquent;

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

        $rows = ArticleEloquent::with('articlePublishedEloquent', 'articleDetailEloquent')
            ->limit($limit)
            ->get()
            ->filter(fn($row) => $row->articlePublishedEloquent !== null && $row->articleDetailEloquent !== null)
            ->sortByDesc(fn($row) => $row->articlePublishedEloquent->created_at);

        $result = [];
        foreach ($rows as $row) {
            $result[] = new TopPagePublishedArticleSummaryDTO(
                id: $row->id,
                user_id: $row->user_id,
                title: $row->articleDetailEloquent->title,
                body: $row->articleDetailEloquent->body,
                thumbnail_image_path: $row->articleDetailEloquent->thumbnail_path,
                created_at: (string)$row->articleDetailEloquent->created_at,
            );
        }

        return $result;
    }
}
