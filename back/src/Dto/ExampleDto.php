<?php


namespace App\Dto;


use Symfony\Component\Serializer\Annotation\Groups;

class ExampleDto
{
    /**
     * @var int
     * @Groups({"write", "read"})
     */
    private $id;

    /**
     * @var string
     * @Groups({"write", "read"})
     */
    private $fromText;

    /**
     * @var string
     * @Groups({"write", "read"})
     */
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