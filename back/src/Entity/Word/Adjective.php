<?php

namespace App\Entity\Word;

use App\Entity\WordObject;
use App\Enum\WordTypeEnum;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Adjective
 * @package App\Entity\Word
 *
 * @ORM\Entity()
 */
final class Adjective extends WordObject
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

    public function setGenre(string $genre): Adjective
    {
        $this->genre = $genre;
        return $this;
    }

    public function getPlural(): string
    {
        return $this->plural;
    }

    public function setPlural(string $plural): Adjective
    {
        $this->plural = $plural;
        return $this;
    }


    public function getType(): string
    {
        return WordTypeEnum::ADJECTIVE;
    }
}