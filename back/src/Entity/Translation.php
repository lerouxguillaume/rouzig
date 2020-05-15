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
     * @ORM\ManyToMany(targetEntity="Example", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $examples;

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

    public function getId(): ?int
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

    public function getExampleById(int $id): ?Example
    {
        /** @var Example $example */
        foreach ($this->getExamples() as $example) {
            if ($example->getId() === $id) {
                return $example;
            }
        }
        return null;
    }

    public function setExamples(array $examples): Translation
    {
        $this->examples->clear();

        foreach ($examples as $example) {
            $this->addExample($example);
        }

        return $this;
    }

    public function addExample(Example $example): Translation
    {
        $this->examples->add($example);
        return $this;
    }

    public function removeExample(Example $example): Translation
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