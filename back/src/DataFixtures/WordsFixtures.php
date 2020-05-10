<?php

namespace App\DataFixtures;

use App\Entity\Translation;
use App\Entity\Word\Noun;
use App\Entity\Word\Verb;
use App\Entity\WordObject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class WordsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->createWord(
            'danser',
            WordObject::STATUS_APPROVED,
            [
                $this->getReference(TranslationFixtures::TRANSLATION_DANSER_1_REFERENCE),
            ],
            $manager
        );

        $this->createWord(
            'manger',
            WordObject::STATUS_PENDING,
            [
                $this->getReference(TranslationFixtures::TRANSLATION_MANGER_1_REFERENCE),
            ],
            $manager
        );

        $this->createWord(
            'dormir',
            WordObject::STATUS_PENDING,
            [
                $this->getReference(TranslationFixtures::TRANSLATION_DORMIR_1_REFERENCE),
            ],
            $manager,
            Noun::class
        );

        $manager->flush();
    }

    private function createWord($text, $status, $translations, $manager, $className = Verb::class)
    {
        $word = new $className();
        $word
            ->setText($text)
            ->setLanguage(WordObject::LANGUAGE_BR)
            ->setStatus($status)
            ->setVersion(1)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime())
        ;

        /** @var Translation $translation */
        foreach ($translations as $translation) {
            $word->addTranslation($translation);
        }
        $manager->persist($word);

    }
}
