<?php

namespace App\DataFixtures;

use App\Entity\Example;
use App\Entity\Translation;
use App\Entity\Word;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TranslationFixtures extends Fixture
{
    public const TRANSLATION_DANSER_1_REFERENCE = 'translation.danser-1';

    public function load(ObjectManager $manager)
    {
        $this->createTranslation(
            'dañsal',
            [
                $this->getReference(ExampleFixtures::EXAMPLE_DANSER_1_REFERENCE),
                $this->getReference(ExampleFixtures::EXAMPLE_DANSER_2_REFERENCE),
            ],
            $manager,
            self::TRANSLATION_DANSER_1_REFERENCE

        );

        $manager->flush();
    }

    private function createTranslation(string $word, array $examples, ObjectManager $manager, string $ref = null) : Translation
    {
        $translation = new Translation();
        $translation
            ->setText($word)
            ->setDescription('description')
            ->setLanguage(Word::LANGUAGE_FR)
            ->setType('type')
        ;
        foreach ($examples as $example) {
            $translation->getExamples()->add($example);
        }

        $manager->persist($translation);
        if (!empty($ref)) {
            $this->addReference($ref, $translation);
        }

        return $translation;
    }
}
