<?php declare(strict_types=1);

namespace Org\Model;

use Arc\Db\Model;

class Note extends Model
{
    private ?int $userId = null;
    private string $content = '';
    private string $dateChanged = '';
    private string $color = '';

    public static function tableName(): string
    {
        return 'notes';
    }

    public static function attributes(): array
    {
        return ['userId', 'content', 'color', 'dateChanged'];
    }

    public function validationRules(): array
    {
        return [
            ['content' => ['required' => true]],
            ['content' => ['string' => ['maxLength' => 255]]],
            ['color' => ['regex'  => ['pattern' => '/^#[A-Fa-f0-9]{6}$/']]],
        ];
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getDateChanged(): string
    {
        return $this->dateChanged;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setContent(string $newContent): self
    {
        $this->content = $newContent;
        $this->dateChanged = date('Y-m-d H:i:s');

        return $this;
    }

    public function setColor(string $newColor): self
    {
        $this->color = $newColor;
        $this->dateChanged = date('Y-m-d H:i:s');

        return $this;
    }

    public function setDateChanged(string $dateChanged): self
    {
        $this->dateChanged = $dateChanged;

        return $this;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }
}
