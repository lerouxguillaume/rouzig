<?php

namespace App\Entity;

use App\Dto\ExampleDto;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Example
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

    public function getFromLanguage(): string
    {
        return $this->fromLanguage;
    }

    public function setFromLanguage(string $fromLanguage): Example
    {
        $this->fromLanguage = $fromLanguage;
        return $this;
    }

    public function getFromText(): string
    {
        return $this->fromText;
    }

    public function setFromText(string $fromText): Example
    {
        $this->fromText = $fromText;
        return $this;
    }

    public function getToLanguage(): string
    {
        return $this->toLanguage;
    }

    public function setToLanguage(string $toLanguage): Example
    {
        $this->toLanguage = $toLanguage;
        return $this;
    }

    public function getToText(): string
    {
        return $this->toText;
    }

    public function setToText(string $toText): Example
    {
        $this->toText = $toText;
        return $this;
    }
}