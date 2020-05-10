<?php

namespace App\DataFixtures;

use App\Entity\Translation;
use App\Entity\WordObject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TranslationFixtures extends Fixture
{
    public const TRANSLATION_DANSER_1_REFERENCE = 'translation.danser-1';
    public const TRANSLATION_MANGER_1_REFERENCE = 'translation.manger-1';
    public const TRANSLATION_DORMIR_1_REFERENCE = 'translation.dormir-1';

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

        $this->createTranslation(
            'debriñ',
            [
                $this->getReference(ExampleFixtures::EXAMPLE_MANGER_1_REFERENCE),
            ],
            $manager,
            self::TRANSLATION_MANGER_1_REFERENCE

        );
        $this->createTranslation(
            'kouskiñ',
            [
            ],
            $manager,
            self::TRANSLATION_DORMIR_1_REFERENCE

        );

        $manager->flush();
    }

    private function createTranslation(string $word, array $examples, ObjectManager $manager, string $ref = null) : Translation
    {
        $translation = new Translation();
        $translation
            ->setText($word)
            ->setDescription('description')
            ->setLanguage(WordObject::LANGUAGE_FR)
        ;
        foreach ($examples as $example) {
            $translation->addExample($example);
        }

        $manager->persist($translation);
        if (!empty($ref)) {
            $this->addReference($ref, $translation);
        }

        return $translation;
    }
}
