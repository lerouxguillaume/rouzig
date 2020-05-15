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
final class Other extends WordObject
{
    public function getType(): string
    {
        return WordTypeEnum::OTHER;
    }
}