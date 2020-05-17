<?php

namespace App\Entity\Word;

use App\Entity\WordObject;
use App\Enum\WordTypeEnum;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Pronoun
 * @package App\Entity\Word
 *
 * @ORM\Entity()
 */
final class Pronoun extends WordObject
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

    public function getType(): string
    {
        return WordTypeEnum::PRONOUN;
    }
}