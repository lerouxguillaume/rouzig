<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AbstractWord
 * @package App\Entity
 * @ORM\MappedSuperclass()
 */
abstract class AbstractWord
{
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
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
    private $type;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return AbstractWord
     */
    public function setText(string $text): AbstractWord
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
     * @return AbstractWord
     */
    public function setLanguage(string $language): AbstractWord
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return AbstractWord
     */
    public function setType(?string $type): AbstractWord
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return AbstractWord
     */
    public function setDescription(?string $description): AbstractWord
    {
        $this->description = $description;
        return $this;
    }
}