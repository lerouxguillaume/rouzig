<?php

namespace App\Dto;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource(
 *     shortName="Search",
 *     itemOperations={"GET"},
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

    /**
     * @return string
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return SearchDto
     */
    public function setText(?string $text): SearchDto
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return int
     */
    public function getCount(): ?int
    {
        return $this->count;
    }

    /**
     * @param int $count
     * @return SearchDto
     */
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

    /**
     * @param string $fromLanguage
     * @return SearchDto
     */
    public function setFromLanguage(?string $fromLanguage): SearchDto
    {
        $this->fromLanguage = $fromLanguage;
        return $this;
    }

    /**
     * @return string
     */
    public function getToLanguage(): ?string
    {
        return $this->toLanguage;
    }

    /**
     * @param string $toLanguage
     * @return SearchDto
     */
    public function setToLanguage(?string $toLanguage): SearchDto
    {
        $this->toLanguage = $toLanguage;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return SearchDto
     */
    public function setUpdatedAt(?\DateTime $updatedAt): SearchDto
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}