<?php

namespace App\DataFixtures;

use App\Entity\Word;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class WordsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->createWord(
            'danser',
            [
                $this->getReference(TranslationFixtures::TRANSLATION_DANSER_1_REFERENCE),
            ],
            $manager
        );

        $manager->flush();
    }

    private function createWord($text, $translations, $manager)
    {
        $word = new Word();
        $word
            ->setText($text)
            ->setLanguage(Word::LANGUAGE_BR)
            ->setStatus(Word::STATUS_PENDING)
            ->setVersion(1)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime())
        ;

        foreach ($translations as $translation) {
            $word->getTranslations()->add($translation);
        }
        $manager->persist($word);

    }
}
