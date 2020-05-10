<?php

namespace App\Dto;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use App\Enum\ErrorCodes;

/**
 * Class WordOutput
 * @package App\Dto
 *
 * @ApiResource(
 *          shortName="Word",
 *          collectionOperations={"GET", "POST"},
 *          itemOperations={"GET", "PATCH", "DELETE"},
 *      )
 * )
 */
class WordDto
{
    /**
     * @var int
     * @ApiProperty(identifier=true)
     */
    private $id;

    /**
     * @var string
     */
    private $word;

    /**
     * @var string
     * @Assert\NotBlank(payload={"code"=ErrorCodes::EMPTY_VALUE})
     */
    private $description;

    /** @var string */
    private $language;

    /** @var string */
    private $wordType;

    /** @var UserOutput */
    private $author;

    /** @var string */
    private $status;

    /** @var DateTime */
    private $updatedAt;

    /**
     * @var TranslationDto[]
     */
    private $translations = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): WordDto
    {
        $this->id = $id;
        return $this;
    }

    public function getWord(): ?string
    {
        return $this->word;
    }

    public function setWord(string $word): WordDto
    {
        $this->word = $word;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): WordDto
    {
        $this->description = $description;
        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): WordDto
    {
        $this->language = $language;
        return $this;
    }

    public function getWordType(): ?string
    {
        return $this->wordType;
    }

    public function setWordType(?string $wordType): WordDto
    {
        $this->wordType = $wordType;
        return $this;
    }

    public function getAuthor(): ?UserOutput
    {
        return $this->author;
    }

    public function setAuthor(UserOutput $author): WordDto
    {
        $this->author = $author;
        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): WordDto
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function addTranslation($translation): array
    {
        $this->translations[] = $translation;
        return $this->translations;
    }

    public function getTranslations(): ?array
    {
        return $this->translations;
    }

    public function setTranslations(array $translations): WordDto
    {
        $this->translations = $translations;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return WordDto
     */
    public function setStatus(?string $status): WordDto
    {
        $this->status = $status;
        return $this;
    }
}