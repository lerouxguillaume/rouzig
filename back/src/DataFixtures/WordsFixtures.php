<?php

namespace App\DataFixtures;

use App\Entity\Translation;
use App\Entity\Word;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class WordsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->createWord(
            'danser',
            Word::STATUS_APPROVED,
            [
                $this->getReference(TranslationFixtures::TRANSLATION_DANSER_1_REFERENCE),
            ],
            $manager
        );

        $this->createWord(
            'manger',
            Word::STATUS_PENDING,
            [
                $this->getReference(TranslationFixtures::TRANSLATION_MANGER_1_REFERENCE),
            ],
            $manager
        );

        $this->createWord(
            'dormir',
            Word::STATUS_PENDING,
            [
                $this->getReference(TranslationFixtures::TRANSLATION_DORMIR_1_REFERENCE),
            ],
            $manager
        );

        $manager->flush();
    }

    private function createWord($text, $status, $translations, $manager)
    {
        $word = new Word();
        $word
            ->setText($text)
            ->setLanguage(Word::LANGUAGE_BR)
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
