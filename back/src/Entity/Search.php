<?php

namespace App\Entity;

use App\Dto\SearchDto;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Exception\FeatureNotImplementedException;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SearchRepository")
 *
 * Class Search
 * @package App\Entity
 */
class Search implements DtoProvider
{
    use TimestampableEntity;

    /**
     * @ORM\Id
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
     * @ORM\Column(type="string", length=8, nullable=true)
     */
    private $fromLanguage;

    /**
     * @var string
     * @ORM\Column(type="string", length=8, nullable=true)
     */
    private $toLanguage;


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
     * @return string
     */
    public function getText(): ?string
    {
        return $this->text;
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

    public function populateFromDto($dto, $context = [])
    {
        throw new FeatureNotImplementedException();
    }

    public function getDto()
    {
        $output = new SearchDto();
        $output
            ->setText($this->getText())
            ->setToLanguage($this->getToLanguage())
            ->setFromLanguage($this->getFromLanguage())
            ->setCount($this->getCount())
            ->setUpdatedAt($this->getUpdatedAt())
        ;

        return $output;
    }
}