<?php

namespace App\Entity\Word;

use App\Entity\WordObject;
use App\Enum\WordTypeEnum;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Noun
 * @package App\Entity\Word
 *
 * @ORM\Entity()
 */
final class Noun extends WordObject
{
    /**
     * @var string
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $genre;

    /**
     * @var string
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $plural;

    /**
     * @return string
     */
    public function getGenre(): string
    {
        return $this->genre;
    }

    /**
     * @param string $genre
     * @return Noun
     */
    public function setGenre(string $genre): Noun
    {
        $this->genre = $genre;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlural(): string
    {
        return $this->plural;
    }

    /**
     * @param string $plural
     * @return Noun
     */
    public function setPlural(string $plural): Noun
    {
        $this->plural = $plural;
        return $this;
    }

    public function getType(): string
    {
        return WordTypeEnum::NOUN;
    }
}