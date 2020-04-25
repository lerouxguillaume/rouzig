<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity()
 * @ApiResource(
 *     shortName="Word",
 * )
 * @ApiFilter(SearchFilter::class, properties={"text" : "ipartial"})

 */
class Word
{
    use TimestampableEntity;

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $text;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $language;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $translation;

    /**
     * @var array
     * @ORM\Column(type="array")
     */
    private $synonym;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $version;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $author;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Word
     */
    public function setId(int $id): Word
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return Word
     */
    public function setText(string $text): Word
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     * @return Word
     */
    public function setLanguage(string $language): Word
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Word
     */
    public function setDescription(string $description): Word
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getTranslation(): string
    {
        return $this->translation;
    }

    /**
     * @param string $translation
     * @return Word
     */
    public function setTranslation(string $translation): Word
    {
        $this->translation = $translation;
        return $this;
    }

    /**
     * @return array
     */
    public function getSynonym(): array
    {
        return $this->synonym;
    }

    /**
     * @param array $synonym
     * @return Word
     */
    public function setSynonym(array $synonym): Word
    {
        $this->synonym = $synonym;
        return $this;
    }

    /**
     * @return int
     */
    public function getVersion(): int
    {
        return $this->version;
    }

    /**
     * @param int $version
     * @return Word
     */
    public function setVersion(int $version): Word
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Word
     */
    public function setStatus(string $status): Word
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @param User $author
     * @return Word
     */
    public function setAuthor(User $author): Word
    {
        $this->author = $author;
        return $this;
    }
}