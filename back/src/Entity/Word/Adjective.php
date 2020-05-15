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
    public function getType(): string
    {
        return WordTypeEnum::ADJECTIVE;
    }
}