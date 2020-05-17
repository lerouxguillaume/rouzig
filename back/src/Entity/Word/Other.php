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
    /**
     * @var string
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $typeName;

    /**
     * @return string
     */
    public function getTypeName(): string
    {
        return $this->typeName;
    }

    /**
     * @param string $typeName
     * @return Other
     */
    public function setTypeName(string $typeName): Other
    {
        $this->typeName = $typeName;
        return $this;
    }

    public function getType(): string
    {
        return WordTypeEnum::OTHER;
    }
}