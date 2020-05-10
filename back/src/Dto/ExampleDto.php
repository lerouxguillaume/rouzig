<?php


namespace App\Dto;


class ExampleDto
{
    /** @var int */
    private $id;

    /** @var string */
    private $fromText;

    /** @var string */
    private $toText;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): ExampleDto
    {
        $this->id = $id;
        return $this;
    }

    public function getFromText(): ?string
    {
        return $this->fromText;
    }

    public function setFromText(?string $fromText): ExampleDto
    {
        $this->fromText = $fromText;
        return $this;
    }

    public function getToText(): ?string
    {
        return $this->toText;
    }

    public function setToText(?string $toText): ExampleDto
    {
        $this->toText = $toText;
        return $this;
    }
}