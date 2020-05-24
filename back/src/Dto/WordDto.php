<?php

namespace App\Dto;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Enum\WordTypeEnum;
use DateTime;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Validator\Constraints as Assert;
use App\Enum\ErrorCodes;

/**
 * Class WordOutput
 * @package App\Dto
 *
 * @ApiResource(
 *          normalizationContext={"groups"={"read_word"}},
 *          shortName="Word",
 *          collectionOperations={"GET"},
 *          itemOperations={
 *              "GET",
 *          },
 *      )
 * )
 */
class WordDto
{
    /**
     * @var int
     * @ApiProperty(identifier=true)
     * @Groups({"write_translation", "read_translation", "read_word"})
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(payload={"code"=ErrorCodes::EMPTY_VALUE})
     * @Groups({"write_translation", "read_translation"})
     */
    private $word;

    /**
     * @var string
     * @Groups({"write_translation", "read_translation", "read_word"})
     */
    private $description;

    /**
     * @var string
     * @Assert\NotBlank(payload={"code"=ErrorCodes::EMPTY_VALUE})
     * @Groups({"write_translation", "read_translation", "read_word"})
     */
    private $language;

    /**
     * @var string
     * @Assert\NotBlank(payload={"code"=ErrorCodes::EMPTY_VALUE})
     * @Assert\Choice(callback={WordTypeEnum::class, "getArray"})
     * @Groups({"write_translation", "read_translation", "read_word"})
     */
    private $wordType;

    /**
     * @var string
     * @Groups({"write_translation", "read_translation", "read_word"})
     */
    private $genre;

    /**
     * @var string
     * @Groups({"write_translation", "read_translation", "read_word"})
     */
    private $otherType;

    /**
     * @var string
     * @Groups({"write_translation", "read_translation", "read_word"})
     */
    private $plural;

    /**
     * @var UserDto
     * @Groups({"read_translation", "read_word"})
     */
    private $author;

    /**
     * @var DateTime
     * @Groups({"read_translation", "read_word"})
     */
    private $updatedAt;

    /**
     * @var TranslationDto[]
     * @Assert\Valid()
     * @Groups({"read_word"})
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

    public function getAuthor(): ?UserDto
    {
        return $this->author;
    }

    public function setAuthor(UserDto $author): WordDto
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

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): WordDto
    {
        $this->genre = $genre;
        return $this;
    }

    public function getOtherType(): ?string
    {
        return $this->otherType;
    }

    public function setOtherType(?string $otherType): WordDto
    {
        $this->otherType = $otherType;
        return $this;
    }

    public function getPlural(): ?string
    {
        return $this->plural;
    }

    public function setPlural(?string $plural): WordDto
    {
        $this->plural = $plural;
        return $this;
    }
}