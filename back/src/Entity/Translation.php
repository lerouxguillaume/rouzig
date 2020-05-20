<?php

namespace App\Entity;

use App\Dto\ExampleDto;
use App\Dto\TranslationDto;
use App\Enum\WordStatus;
use App\Factory\WordFactory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity()
 */
class Translation implements DtoProvider
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

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
    private $originalWord;

    /**
     * @var WordObject
     * @ORM\OneToOne(targetEntity="WordObject", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $translatedWord;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $author;

    /**
     * @var string
     * @ORM\Column(type="string", length=48, nullable=false)
     */
    private $status;

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

    public function getOriginalWord(): ?WordObject
    {
        return $this->originalWord;
    }

    public function setOriginalWord(?WordObject $originalWord): Translation
    {
        $this->originalWord = $originalWord;

        if (!empty($originalWord)) {
            $originalWord->addTranslation($this);
        }

        return $this;
    }

    public function getTranslatedWord(): ?WordObject
    {
        return $this->translatedWord;
    }

    public function setTranslatedWord(?WordObject $translatedWord): Translation
    {
        $this->translatedWord = $translatedWord;
        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): Translation
    {
        $this->author = $author;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
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

        if (!empty($translationDto->getOriginalWord())) {
            $original = $this->getOriginalWord() ?? WordFactory::create($translationDto->getOriginalWord()->getWordType());

            $this->setOriginalWord($original->populateFromDto($translationDto->getOriginalWord()));
        }

        if (!empty($translationDto->getTranslatedWord())) {
            $translation = $this->getTranslatedWord() ?? WordFactory::create($translationDto->getTranslatedWord()->getWordType());

            $this->setTranslatedWord($translation->populateFromDto($translationDto->getTranslatedWord()));
        }

        $updatedExamples = [];

        /** @var ExampleDto $exampleDto */
        foreach ($translationDto->getExamples() as $exampleDto) {
            $example = ($translationDto->getId() ? $this->getExampleById($exampleDto->getId()) : null) ?? new Example();
            $updatedExamples[] = $example->populateFromDto($exampleDto, [
                'fromLanguage' => $this->getOriginalWord()->getLanguage(),
                'toLanguage' => $this->getTranslatedWord()->getLanguage()
            ]);
        }

        $this->setExamples($updatedExamples);

        return $this;
    }

    public function getDto()
    {
        $translationDto = new TranslationDto();
        $translationDto
            ->setId($this->getId())
            ->setOriginalWord($this->getOriginalWord()->getDto())
            ->setTranslatedWord($this->getTranslatedWord()->getDto())
        ;

        /** @var Example $example */
        foreach ($this->getExamples() as $example) {
            $translationDto->addExample($example->getDto());
        }

        return $translationDto;
    }
}