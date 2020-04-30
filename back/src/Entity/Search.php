<?php

namespace App\Entity;

use ApiPlatform\Core\Action\NotFoundAction;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity()
 * @ApiResource(
 *     shortName="Search",
 *     itemOperations={
 *         "get"={
 *             "controller"=NotFoundAction::class,
 *             "read"=false,
 *             "output"=false,
 *         },
 *     },
 *     collectionOperations={"get"}
 * )
 * @ApiFilter(OrderFilter::class, properties={"count", "text"}, arguments={"orderParameterName"="order"})
 */
class Search
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
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $text;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $count = 0;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fromLanguage;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $toLanguage;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return Search
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     * @return Search
     */
    public function setCount(int $count): Search
    {
        $this->count = $count;
        return $this;
    }

    public function countAdd(): int
    {
        return $this->count++;
    }

    /**
     * @return string
     */
    public function getFromLanguage(): ?string
    {
        return $this->fromLanguage;
    }

    /**
     * @param string $fromLanguage
     * @return Search
     */
    public function setFromLanguage(string $fromLanguage): Search
    {
        $this->fromLanguage = $fromLanguage;
        return $this;
    }

    /**
     * @return string
     */
    public function getToLanguage(): ?string
    {
        return $this->toLanguage;
    }

    /**
     * @param string $toLanguage
     * @return Search
     */
    public function setToLanguage(string $toLanguage): Search
    {
        $this->toLanguage = $toLanguage;
        return $this;
    }
}