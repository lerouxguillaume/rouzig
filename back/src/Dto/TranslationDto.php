<?php

namespace App\Dto;

use App\Entity\Example;
use Symfony\Component\Validator\Constraints as Assert;
use App\Enum\ErrorCodes;

class TranslationDto
{
    /**
     * @var string
     * @Assert\Type(type="integer", payload={"code"=ErrorCodes::INVALID_TYPE})
     */
    private $id;

    /** @var string */
    private $word;

    /** @var string */
    private $description;

    /** @var string */
    private $language;

    /** @var string */
    private $type;

    /** @var ExampleDto[] */
    private $examples = [];

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): TranslationDto
    {
        $this->id = $id;
        return $this;
    }

    public function getWord(): ?string
    {
        return $this->word;
    }

    public function setWord(?string $word): TranslationDto
    {
        $this->word = $word;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): TranslationDto
    {
        $this->description = $description;
        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): TranslationDto
    {
        $this->language = $language;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): TranslationDto
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param ExampleDto $example
     * @return Example[]
     */
    public function addExample(ExampleDto $example): ?array
    {
        $this->examples[] = $example;
        return $this->examples;
    }
    /**
     * @return Example[]
     */
    public function getExamples(): ?array
    {
        return $this->examples;
    }

    public function setExamples(?array $examples): TranslationDto
    {
        $this->examples = $examples;
        return $this;
    }
}