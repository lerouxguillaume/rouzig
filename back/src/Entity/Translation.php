<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 */
class Translation extends AbstractWord
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
     * @ORM\ManyToMany(targetEntity="Example", cascade={"PERSIST"}, orphanRemoval=true)
     * @ORM\JoinTable(name="translation_examples",
     *      joinColumns={@ORM\JoinColumn(name="translations_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="example_id", referencedColumnName="id", unique=true)}
     *      )
     * @Assert\Valid()
     */
    private $examples;

    /**
     * Translation constructor.
     */
    public function __construct()
    {
        $this->examples = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }


    public function getExamples(): array
    {
        return $this->examples->getValues();
    }

    public function setExamples(array $examples): Translation
    {
        $this->examples = new ArrayCollection($examples);
        return $this;
    }

    public function addExample(Example $example): Translation
    {
        $this->examples->add($example);
        return $this;
    }

    public function removeTransaction(Example $example): Translation
    {
        $this->examples->removeElement($example);
        return $this;
    }
}