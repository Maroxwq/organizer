<?php declare(strict_types=1);

namespace Org\Model;

use Arc\Db\Model;

class Post extends Model
{
    protected string $title = '';
    protected string $content = '';
    protected string $createdAt = '';
    protected string $updatedAt = '';
    protected string $authorName = 'Саша';

    public static function tableName(): string
    {
        return 'posts';
    }

    public static function attributes(): array
    {
        return ['title', 'content', 'createdAt', 'updatedAt'];
    }

    public function validationRules(): array
    {
        return [
            ['title'   => ['required' => true]],
            ['title'   => ['string'   => ['maxLength' => 255]]],
            ['content' => ['required' => true]],
            ['content' => ['string'   => ['maxLength' => 1000]]],
        ];
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    public function setTitle(string $newTitle): void
    {
        $this->title = $newTitle;
        $this->updatedAt = date('Y-m-d H:i:s');
    }

    public function changeContent(string $newContent): void
    {
        $this->content = $newContent;
        $this->updatedAt = date('Y-m-d H:i:s');
    }
}
