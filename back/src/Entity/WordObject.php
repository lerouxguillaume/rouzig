<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Enum\ErrorCodes;
use App\Dto\WordDto;

/**
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "verb" = "App\Entity\Word\Verb",
 *     "noun" = "App\Entity\Word\Noun",
 *     "adjective" = "App\Entity\Word\Adjective",
 *     "adverb" = "App\Entity\Word\Adverb",
 *     "conjuction" = "App\Entity\Word\Conjunction",
 *     "pronoun" = "App\Entity\Word\Pronoun",
 *     "preposition" = "App\Entity\Word\Preposition"
 * })
 */
abstract class WordObject
{
    const STATUS_APPROVED = 'approved';
    const STATUS_DELETED = 'deleted';
    const STATUS_PENDING = 'pending';

    const LANGUAGE_BR = 'br';
    const LANGUAGE_FR = 'fr';

    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="Translation", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $translations;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $version = 1;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status = WordObject::STATUS_PENDING;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $author;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(payload={"code"=ErrorCodes::EMPTY_VALUE})
     */
    private $text;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(payload={"code"=ErrorCodes::EMPTY_VALUE})
     */
    private $language;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * WordObject constructor.
     */
    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): WordObject
    {
        $this->id = $id;
        return $this;
    }

    public function getTranslations(): array
    {
        return $this->translations->getValues();
    }

    public function getTranslationById(int $id): ?Translation
    {
        /** @var Translation $translation */
        foreach ($this->translations as $translation) {
            if ($translation->getId() === $id) {
                return $translation;
            }
        }
        return null;
    }

    public function setTranslations(array $translations): WordObject
    {
        $this->translations->clear();
        foreach ($translations as $translation) {
            $this->addTranslation($translation);
        }
        return $this;
    }

    public function addTranslation(Translation $translation): WordObject
    {
        $this->translations->add($translation);
        return $this;
    }

    public function removeTranslation(Translation $translation): WordObject
    {
        $this->translations->removeElement($translation);
        return $this;
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function setVersion(int $version): WordObject
    {
        $this->version = $version;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): WordObject
    {
        $this->status = $status;
        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): WordObject
    {
        $this->author = $author;
        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): WordObject
    {
        $this->text = $text;
        return $this;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): WordObject
    {
        $this->language = $language;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): WordObject
    {
        $this->description = $description;
        return $this;
    }
}