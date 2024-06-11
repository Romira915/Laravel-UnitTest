<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleTag extends Model
{
    use HasFactory, HasUuids;

    public function __construct(
        private string $id = '',
        private string $article_id = '',
        private string $user_id = '',
        private string $tag_name = '',
    )
    {
        $this->setTag($tag_name);
    }

    private function setTag(string $tag_name): void
    {
//        if (!TagValidator::validate($tag_name)) {
//            throw new \InvalidArgumentException('Invalid tag name');
//        }

        $this->tag_name = $tag_name;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getArticleId(): string
    {
        return $this->article_id;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function getTag(): string
    {
        return $this->tag_name;
    }
}
