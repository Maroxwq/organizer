<?php declare(strict_types=1);

namespace Org\Model;

class Post
{
    private ?int $id;
    private string $title;
    private string $content;
    private string $createdAt;
    private string $updatedAt;
    private string $authorName;

    public function __construct(string $title = '', string $content = '', string $authorName = 'Саша')
    {
        $this->id = null;
        $this->title = $title;
        $this->content = $content;
        $this->authorName = $authorName;
        $this->createdAt = date('Y-m-d H:i:s');
        $this->updatedAt = date('Y-m-d H:i:s');
    }

    public function validationRules(): array
    {
        return [
            ['title' => ['required' => true]],
            ['title' => ['string' => ['maxLength' => 255]]],
            ['content' => ['required' => true]],
            ['content' => ['string' => ['maxLength' => 1000]]]
        ];
    }

    public function load(array $data): bool
    {
        $this->changeTitle($data['title']);
        $this->changeContent($data['content']);
        return true;
    }

    public function fromDbRow(array $dbRow): void
    {
        $this->id = $dbRow['id'];
        $this->title = $dbRow['title'];
        $this->content = $dbRow['content'];
        $this->createdAt = $dbRow['createdAt'];
        $this->updatedAt = $dbRow['updatedAt'];
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function changeTitle(string $newTitle): void
    {
        $this->title = $newTitle;
        $this->updatedAt = date('Y-m-d H:i:s');
    }

    public function changeContent(string $newContent): void
    {
        $this->content = $newContent;
        $this->updatedAt = date('Y-m-d H:i:s');
    }

    public function getAuthorName(): string
    {
        return $this->authorName;
    }
}
