<?php


namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\TranslationDto;
use App\Dto\WordDto;
use App\Entity\Translation;
use App\Entity\Word\Adjective;
use App\Entity\Word\Adverb;
use App\Entity\Word\Conjunction;
use App\Entity\Word\Noun;
use App\Entity\Word\Preposition;
use App\Entity\Word\Pronoun;
use App\Entity\Word\Verb;
use App\Entity\WordObject;
use App\Enum\WordTypeEnum;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class WordDataTransformer
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

    public function transform($object, string $to)
    {
        if ($object instanceof WordObject && $to === WordDto::class) {
            return $this->entityToDto($object);
        } elseif ($object instanceof WordDto && $to === WordObject::class) {
            return $this->dtoToEntity($object);
        } else {
            throw new \LogicException('Transformation not supported');
        }
    }

    private function entityToDto(WordObject $word): WordDto
    {
        $output = new WordDto();
        $output
            ->setId($word->getId())
            ->setWord($word->getText())
            ->setDescription($word->getDescription())
            ->setUpdatedAt($word->getUpdatedAt())
            ->setLanguage($word->getLanguage())
            ->setStatus($word->getStatus())
            ->setWordType($this->getWordType($word))
        ;

        /** @var Translation $translation */
        foreach ($word->getTranslations() as $translation) {
            $output->addTranslation($this->translationDataTransformer->transform($translation, TranslationDto::class));
        }

        return $output;
    }

    private function dtoToEntity(WordDto $word): WordObject
    {
        $output = $this->getWordObject($word->getWordType());
        $output
            ->setId($word->getId())
            ->setText($word->getWord())
            ->setDescription($word->getDescription())
            ->setLanguage($word->getLanguage())
            ->setStatus($word->getStatus())
        ;

        /** @var TranslationDto $translation */
        foreach ($word->getTranslations() as $translation) {
            $output->addTranslation($this->translationDataTransformer->transform($translation, Translation::class));
        }

        return $output;
    }

    private function getWordObject(string $type) : WordObject
    {
        switch ($type) {
            case WordTypeEnum::ADJECTIVE:
                return new Adjective();
            case WordTypeEnum::ADVERB:
                return new Adverb();
            case WordTypeEnum::CONJUNCTION:
                return new Conjunction();
            case WordTypeEnum::NOUN:
                return new Noun();
            case WordTypeEnum::PRONOUN:
                return new Pronoun();
            case WordTypeEnum::PREPOSITION:
                return new Preposition();
            case WordTypeEnum::VERB:
                return new Verb();
        }

        throw new \Exception('Other type not handled yet');
    }

    private function getWordType(WordObject $object) : string
    {
        switch (get_class($object)) {
            case Adjective::class:
                return WordTypeEnum::ADJECTIVE;
            case Adverb::class:
                return WordTypeEnum::ADVERB;
            case Conjunction::class:
                return WordTypeEnum::CONJUNCTION;
            case Noun::class:
                return WordTypeEnum::NOUN;
            case Pronoun::class:
                return WordTypeEnum::PRONOUN;
            case Preposition::class:
                return WordTypeEnum::PREPOSITION;
            case Verb::class:
                return WordTypeEnum::VERB;
        }

        return WordTypeEnum::OTHER;
    }
}