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

        $rows = ArticleEloquent::query()
            ->select([
                'articles.id',
                'article_details.title',
                'article_details.body',
                'article_details.thumbnail_path',
                'article_details.created_at'
            ])
            ->join('article_published', 'articles.id', '=', 'article_published.article_id')
            ->join('article_details', 'articles.id', '=', 'article_details.article_id')
            ->limit($limit)
            ->get();

        $result = [];
        foreach ($rows as $row) {
            $result[] = new TopPagePublishedArticleSummaryDTO(
                id: $row->id,
                title: $row->title,
                body: $row->body,
                thumbnail_image_path: $row->thumbnail_path,
                created_at: (string)$row->created_at,
            );
        }

        return $result;
    }
}
