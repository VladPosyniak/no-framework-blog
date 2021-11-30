<?php
namespace Src\entity;

use JetBrains\PhpStorm\ArrayShape;
use Ramsey\Uuid\UuidInterface;

class ArticleEntity
{
    private UuidInterface $id;
    private string $title;
    private string $text;
    private string $authorID;
    private int $createdTimestamp;

    public function __construct(UuidInterface $id, string $title, string $text, string $authorID, string $createdTimestamp)
    {
        $this->id = $id;
        $this->title = $title;
        $this->text = $text;
        $this->authorID = $authorID;
        $this->createdTimestamp = $createdTimestamp;
    }

    public function getID(): UuidInterface
    {
        return $this->id;
    }

    #[ArrayShape(['id' => "string", 'title' => "string", 'text' => "string", 'authorID' => "string", 'created' => 'string'])] public function toArray(): array
    {
        return [
            'id' => $this->id->toString(),
            'title' => $this->title,
            'text' => $this->text,
            'authorID' => $this->authorID,
            'created' => date("Y-m-d H:i:s", $this->createdTimestamp)
        ];
    }
}