<?php


namespace App\DataTransformer;

use App\Dto\TranslationDto;
use App\Dto\WordDto;
use App\Entity\Translation;
use App\Entity\WordObject;
use App\Factory\WordFactory;

class WordDataTransformer implements DataTransformerInterface
{
    /** @var TranslationDataTransformer */
    private $translationDataTransformer;

    /**
     * WordDataTransformer constructor.
     * @param TranslationDataTransformer $translationDataTransformer
     */
    public function __construct(TranslationDataTransformer $translationDataTransformer)
    {
        $this->translationDataTransformer = $translationDataTransformer;
    }

    public function populateDto($wordObject): WordDto
    {
        $wordDto = new WordDto();

        $wordDto
            ->setId($wordObject->getId())
            ->setWord($wordObject->getText())
            ->setDescription($wordObject->getDescription())
            ->setUpdatedAt($wordObject->getUpdatedAt())
            ->setLanguage($wordObject->getLanguage())
            ->setStatus($wordObject->getStatus())
            ->setWordType($wordObject->getType())
        ;

        /** @var Translation $translation */
        foreach ($wordObject->getTranslations() as $translation) {
            $wordDto->addTranslation($this->translationDataTransformer->populateDto($translation));
        }

        return $wordDto;
    }

    public function populateEntity($wordDto, $wordObject = null, $context = []): WordObject
    {
        if (empty($wordObject)) {
            $wordObject = WordFactory::create($wordDto->getWordType());
        }

        $wordObject
            ->setId($wordDto->getId())
            ->setText($wordDto->getWord())
            ->setDescription($wordDto->getDescription())
            ->setLanguage($wordDto->getLanguage())
        ;

        $updatedTranslations = [];

        /** @var TranslationDto $translationDto */
        foreach ($wordDto->getTranslations() as $translationDto) {
            $translation = ($translationDto->getId() ? $wordObject->getTranslationById($translationDto->getId()) : null);
            $updatedTranslations[] = $this->translationDataTransformer->populateEntity($translationDto, $translation, ['fromLanguage' => $wordObject->getLanguage()]);
        }

        $wordObject->setTranslations($updatedTranslations);

        return $wordObject;
    }
}