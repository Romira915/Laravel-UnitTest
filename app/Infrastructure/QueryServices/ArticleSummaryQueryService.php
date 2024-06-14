<?php

declare(strict_types=1);

namespace App\Infrastructure\QueryServices;

use App\Http\DAO\TopPagePublishedArticleSummaryDTO;
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
            ->get();

        $result = [];
        foreach ($rows as $row) {
            $result[] = new TopPagePublishedArticleSummaryDTO(
                id: $row->id,
                title: $row->articleDetailEloquent->title,
                body: $row->articleDetailEloquent->body,
                thumbnail_image_path: $row->articleDetailEloquent->thumbnail_path,
                created_at: (string)$row->articleDetailEloquent->created_at,
            );
        }

        return $result;
    }
}
