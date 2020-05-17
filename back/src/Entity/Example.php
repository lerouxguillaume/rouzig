<?php

namespace App\Entity;

use App\Dto\ExampleDto;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Example implements DtoProvider
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $fromLanguage;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $fromText;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $toLanguage;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $toText;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Example
     */
    public function setId(?int $id): Example
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getFromLanguage(): string
    {
        return $this->fromLanguage;
    }

    /**
     * @param string $fromLanguage
     * @return Example
     */
    public function setFromLanguage(string $fromLanguage): Example
    {
        $this->fromLanguage = $fromLanguage;
        return $this;
    }

    /**
     * @return string
     */
    public function getFromText(): string
    {
        return $this->fromText;
    }

    /**
     * @param string $fromText
     * @return Example
     */
    public function setFromText(string $fromText): Example
    {
        $this->fromText = $fromText;
        return $this;
    }

    /**
     * @return string
     */
    public function getToLanguage(): string
    {
        return $this->toLanguage;
    }

    /**
     * @param string $toLanguage
     * @return Example
     */
    public function setToLanguage(string $toLanguage): Example
    {
        $this->toLanguage = $toLanguage;
        return $this;
    }

    /**
     * @return string
     */
    public function getToText(): string
    {
        return $this->toText;
    }

    /**
     * @param string $toText
     * @return Example
     */
    public function setToText(string $toText): Example
    {
        $this->toText = $toText;
        return $this;
    }

    public function populateFromDto($exampleDto, $context = [])
    {
        $this
            ->setId($exampleDto->getId())
            ->setFromText($exampleDto->getFromText())
            ->setToText($exampleDto->getToText())
            ->setFromLanguage($context['fromLanguage'] ?? null)
            ->setToLanguage($context['toLanguage'] ?? null)
        ;

        return $this;
    }

    public function getDto()
    {
        $exampleDto = new ExampleDto();
        $exampleDto
            ->setId($this->getId())
            ->setToText($this->getToText())
            ->setFromText($this->getFromText())
        ;

        return $exampleDto;
    }
}