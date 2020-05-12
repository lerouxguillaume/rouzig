<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Enum\ErrorCodes;

/**
 * @ORM\Entity()
 */
class Translation
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="Example", cascade={"ALL"}, orphanRemoval=true)
     * @ORM\JoinTable(name="translation_examples",
     *      joinColumns={@ORM\JoinColumn(name="translations_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="example_id", referencedColumnName="id", unique=true)}
     *      )
     * @Assert\Valid()
     */
    private $examples;

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
     * Translation constructor.
     */
    public function __construct()
    {
        $this->examples = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(?int $id): Translation
    {
        $this->id = $id;
        return $this;
    }

    public function getExamples(): array
    {
        return $this->examples->getValues();
    }

    public function setExamples(array $examples): Translation
    {
        $this->examples = new ArrayCollection($examples);
        return $this;
    }

    public function addExample(Example $example): Translation
    {
        $this->examples->add($example);
        return $this;
    }

    public function removeTransaction(Example $example): Translation
    {
        $this->examples->removeElement($example);
        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): Translation
    {
        $this->text = $text;
        return $this;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): Translation
    {
        $this->language = $language;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): Translation
    {
        $this->description = $description;
        return $this;
    }
}