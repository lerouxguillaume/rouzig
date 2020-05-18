<?php

namespace App\Entity;

use App\Dto\ExampleDto;
use App\Dto\TranslationDto;
use App\Enum\WordStatus;
use App\Factory\WordFactory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Translation implements DtoProvider
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
     * @ORM\ManyToMany(targetEntity="Example", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $examples;

    /**
     * @var WordObject
     * @ORM\OneToOne(targetEntity="WordObject", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $translation;

    /**
     * Translation constructor.
     */
    public function __construct()
    {
        $this->examples = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Translation
    {
        $this->id = $id;
        return $this;
    }

    public function getExamples(): array
    {
        return $this->examples->getValues();
    }

    public function getExampleById(int $id): ?Example
    {
        /** @var Example $example */
        foreach ($this->getExamples() as $example) {
            if ($example->getId() === $id) {
                return $example;
            }
        }
        return null;
    }

    public function setExamples(array $examples): Translation
    {
        $this->examples->clear();

        foreach ($examples as $example) {
            $this->addExample($example);
        }

        return $this;
    }

    public function addExample(Example $example): Translation
    {
        $this->examples->add($example);
        return $this;
    }

    public function removeExample(Example $example): Translation
    {
        $this->examples->removeElement($example);
        return $this;
    }

    /**
     * @return WordObject
     */
    public function getTranslation(): ?WordObject
    {
        return $this->translation;
    }

    /**
     * @param WordObject $translation
     * @return Translation
     */
    public function setTranslation(?WordObject $translation): Translation
    {
        $this->translation = $translation;
        return $this;
    }

    /**
     * @param TranslationDto $translationDto
     * @param array $context
     * @return $this
     */
    public function populateFromDto($translationDto, $context = [])
    {
        $translationLanguage = null;

        if (!empty($translationDto->getWord())) {
            $translation = $this->getTranslation() ?? WordFactory::create($translationDto->getWord()->getWordType());

            $translation->setStatus(WordStatus::DEFINITION);
            $this->setTranslation($translation->populateFromDto($translationDto->getWord()));
            $translationLanguage = $this->getTranslation()->getLanguage();
        }

        $updatedExamples = [];

        /** @var ExampleDto $exampleDto */
        foreach ($translationDto->getExamples() as $exampleDto) {
            $example = ($translationDto->getId() ? $this->getExampleById($exampleDto->getId()) : null) ?? new Example();
            $updatedExamples[] = $example->populateFromDto($exampleDto, array_merge($context, ['toLanguage' => $translationLanguage]));
        }

        $this->setExamples($updatedExamples);

        return $this;
    }

    public function getDto()
    {
        $translationDto = new TranslationDto();
        $translationDto
            ->setId($this->getId())
            ->setWord($this->getTranslation()->getDto())
        ;

        /** @var Example $example */
        foreach ($this->getExamples() as $example) {
            $translationDto->addExample($example->getDto());
        }

        return $translationDto;
    }
}