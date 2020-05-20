<?php

namespace App\Dto;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Entity\Example;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Enum\ErrorCodes;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use App\Controller\TranslationsController;

/**
 * Class TranslationDto
 * @package App\Dto
 *
 * @ApiResource(
 *          denormalizationContext={
 *                  AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT=true,
 *                  "groups"={"write"}
 *          },
 *          normalizationContext={"groups"={"read"}},
 *          shortName="Translation",
 *          collectionOperations={"GET", "POST"},
 *          itemOperations={
 *              "GET",
 *              "PATCH",
 *              "DELETE",
 *              "post_review"={
 *                  "method"="POST",
 *                  "path"="translations/{id}/review",
 *                  "controller"=TranslationsController::class,
 *              },
 *              "post_validate"={
 *                  "method"="POST",
 *                  "path"="translations/{id}/validate",
 *                  "controller"=TranslationsController::class,
 *              },
 *              "post_reject"={
 *                  "method"="POST",
 *                  "path"="translations/{id}/reject",
 *                  "controller"=TranslationsController::class,
 *              },
 *          },
 *      )
 * )
 */
class TranslationDto
{
    /**
     * @var string
     * @Assert\Type(type="integer", payload={"code"=ErrorCodes::INVALID_TYPE})
     * @ApiProperty(identifier=true)
     * @Groups({"write", "read"})
     */
    private $id;

    /**
     * @var WordDto
     * @Assert\Valid()
     * @Assert\NotNull(payload={"code"=ErrorCodes::EMPTY_VALUE})
     * @ApiSubresource
     * @Groups({"write", "read"})
     */
    private $originalWord;

    /**
     * @var WordDto
     * @Assert\Valid()
     * @ApiSubresource
     * @Groups({"write", "read"})
     */
    private $translatedWord;

    /**
     * @var ExampleDto[]
     * @Assert\Valid()
     * @Groups({"write", "read"})
     */
    private $examples = [];

    /**
     * @var string
     * @Groups({"read"})
     */
    private $status;

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

    public function getOriginalWord(): ?WordDto
    {
        return $this->originalWord;
    }

    public function setOriginalWord(?WordDto $originalWord): TranslationDto
    {
        $this->originalWord = $originalWord;
        return $this;
    }

    public function getTranslatedWord(): ?WordDto
    {
        return $this->translatedWord;
    }

    public function setTranslatedWord(?WordDto $translatedWord): TranslationDto
    {
        $this->translatedWord = $translatedWord;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): TranslationDto
    {
        $this->status = $status;
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