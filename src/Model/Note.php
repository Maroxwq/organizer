<?php declare(strict_types=1);

namespace Org\Model;

class Note
{
    private int $id;
    private string $content;
    private string $dateChanged;
    private string $color;

    public function __construct(string $content, string $color)
    {
        $this->content = $content;
        $this->color = $color;
        $this->dateChanged = date('Y-m-d H:i:s');
    }

    public function validationRules()
    {
        return [
            ['content' => ['required' => true]],
            ['content' => ['string' => ['maxLenght' => 255]]],
            ['color' => ['regex' => '/^#[A-Fa-f0-9]{1,6}$/']],
        ];
    }

    public function fromDbRow(array $dbRow): void
    {
        $this->id = $dbRow['id'];
        $this->content = $dbRow['content'];
        $this->dateChanged = $dbRow['dateChanged'];
        $this->color = $dbRow['color'];
    }

    public function asString(): string
    {
        return "$this->content, $this->dateChanged - $this->color";
    }

    public function getId(): int
    {
        return $this->id;
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
