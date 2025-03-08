<?php declare(strict_types=1);

namespace Org\Model;

use Arc\Db\Model;

class Note extends Model
{
    private string $content;
    private string $dateChanged;
    private string $color;

    public static function tableName(): string
    {
        return 'notes';
    }

    public static function attributes(): array
    {
        return ['content', 'dateChanged', 'color'];
    }

    public function __construct(string $content = '', string $color = '')
    {
        $this->content = $content;
        $this->color = $color;
        $this->dateChanged = date('Y-m-d H:i:s');
    }

    public function validationRules()
    {
        return [
            ['content' => ['required' => true]],
            ['content' => ['string' => ['maxLength' => 255]]],
            ['color' => ['regex' => ['pattern' => '/^#[A-Fa-f0-9]{6}$/']]],
        ];
    }

    public function load(array $data): bool
    {
        $this->changeContent($data['content'] ?? '');
        $this->changeColor($data['color'] ?? '');
        return true;
    }

    public function fromDbRow(array $dbRow): void
    {
        $this->setId((int)$dbRow['id']);
        $this->content = $dbRow['content'];
        $this->dateChanged = $dbRow['dateChanged'];
        $this->color = $dbRow['color'];
    }

    public function asString(): string
    {
        return "$this->content, $this->dateChanged - $this->color";
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

    public function changeContent(string $newContent)
    {
        $this->content = $newContent;
        $this->dateChanged = date('Y-m-d H:i:s');
    }

    public function changeColor(string $newColor)
    {
        $this->color = $newColor;
        $this->dateChanged = date('Y-m-d H:i:s');
    }
}
