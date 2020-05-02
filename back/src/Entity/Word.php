<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity()
 * @ApiResource(
 *     shortName="Word",
 *     collectionOperations={"GET", "POST"},
 *     itemOperations={"GET", "PATCH", "DELETE"},
 * )
 * @ApiFilter(SearchFilter::class, properties={"text" : "partial", "status" : "partial"})
 */
class Word extends AbstractWord
{
    const STATUS_APPROVED = 'approved';
    const STATUS_DELETED = 'deleted';
    const STATUS_PENDING = 'pending';

    const LANGUAGE_BR = 'br';
    const LANGUAGE_FR = 'fr';

    use TimestampableEntity;

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="Translation", cascade={"Persist"}, orphanRemoval=true)
     * @ORM\JoinTable(name="word_translations",
     *      joinColumns={@ORM\JoinColumn(name="word_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="translation_id", referencedColumnName="id", unique=true)}
     *      )
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
    private $status = Word::STATUS_PENDING;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $author;

    /**
     * Word constructor.
     */
    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTranslations(): array
    {
        return $this->translations->getValues();
    }

    public function setTranslations(array $translations): Word
    {
        $this->translations = new ArrayCollection($translations);
        return $this;
    }

    public function addTranslation(Translation $translation): Word
    {
        $this->translations->add($translation);
        return $this;
    }

    public function removeTransaction(Translation $translation): Word
    {
        $this->translations->removeElement($translation);
        return $this;
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function setVersion(int $version): Word
    {
        $this->version = $version;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): Word
    {
        $this->status = $status;
        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): Word
    {
        $this->author = $author;
        return $this;
    }
}