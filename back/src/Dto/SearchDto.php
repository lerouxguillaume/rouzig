<?php

namespace App\Dto;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource(
 *     shortName="Search",
 *     itemOperations={"GET", "DELETE"},
 *     collectionOperations={"GET"},
 *     attributes={"order"={"count": "DESC"}}
 * )
 */
class SearchDto
{
    /**
     * @ApiProperty(identifier=true)
     * @var string
     */
    private $text;

    /**
     * @var int
     */
    private $count;

    /**
     * @var string
     */
    private $fromLanguage;

    /**
     * @var string
     */
    private $toLanguage;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): SearchDto
    {
        $this->text = $text;
        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(?int $count): SearchDto
    {
        $this->count = $count;
        return $this;
    }

    /**
     * @return string
     */
    public function getFromLanguage(): ?string
    {
        return $this->fromLanguage;
    }

    public function setFromLanguage(?string $fromLanguage): SearchDto
    {
        $this->fromLanguage = $fromLanguage;
        return $this;
    }

    public function getToLanguage(): ?string
    {
        return $this->toLanguage;
    }

    public function setToLanguage(?string $toLanguage): SearchDto
    {
        $this->toLanguage = $toLanguage;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): SearchDto
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}