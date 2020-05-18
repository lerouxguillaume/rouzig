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

    /**
     * @var WordDto
     * @Assert\Valid()
     * @Assert\NotNull(payload={"code"=ErrorCodes::EMPTY_VALUE})
     */
    private $word;

    /**
     * @var ExampleDto[]
     * @Assert\Valid()
     */
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

    /**
     * @return WordDto
     */
    public function getWord(): ?WordDto
    {
        return $this->word;
    }

    /**
     * @param WordDto $word
     * @return TranslationDto
     */
    public function setWord(?WordDto $word): TranslationDto
    {
        $this->word = $word;
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