<?php

declare(strict_types=1);

namespace App\Infrastructure\QueryServices;

use App\Http\DAO\TopPagePublishedArticleSummaryDTO;
use Illuminate\Support\Facades\DB;

class ArticleSummaryQueryService
{
    /**
     * @param int $limit
     * @return array<TopPagePublishedArticleSummaryDTO>
     */
    public function getArticleSummaryList(int $limit): array
    {
        $rows = DB::select('
            SELECT a.id,
                   ad.title,
                   ad.body,
                   ad.thumbnail_path,
                   ad.created_at,
                   ad.updated_at
            FROM articles as a
                     INNER JOIN article_published AS ap ON a.id = ap.article_id
                     INNER JOIN article_details AS ad ON a.id = ad.article_id
            ORDER BY ad.created_at DESC
            LIMIT ?
        ', [$limit]);

        $result = [];
        foreach ($rows as $row) {
            $result[] = new TopPagePublishedArticleSummaryDTO(
                id: $row->id,
                title: $row->title,
                body: $row->body,
                thumbnail_image_path: $row->thumbnail_path,
                created_at: $row->created_at,
            );
        }

        return $result;
    }
}
