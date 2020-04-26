<?php

namespace App\DataFixtures;

use App\Entity\Example;
use App\Entity\Word;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ExampleFixtures extends Fixture
{
    public const EXAMPLE_DANSER_1_REFERENCE = 'example.danser-1';
    public const EXAMPLE_DANSER_2_REFERENCE = 'example.danser-2';



    public function load(ObjectManager $manager)
    {
        $this->createExampleFrToBe(
            'air à danser',
            'ton da zañsal',
            $manager,
            self::EXAMPLE_DANSER_1_REFERENCE

        );
        $this->createExampleFrToBe(
            ' chant à danser',
            'kan da zañsal',
            $manager,
            self::EXAMPLE_DANSER_2_REFERENCE
        );

        $manager->flush();
    }

    private function createExampleFrToBe(string $from, string  $to, ObjectManager $manager, string $ref = null) : Example
    {
        $example = new Example();
        $example
            ->setFromLanguage(Word::LANGUAGE_FR)
            ->setToLanguage(Word::LANGUAGE_BR)
            ->setFromText($from)
            ->setToText($to)
        ;
        $manager->persist($example);

        if (!empty($ref)) {
            $this->addReference($ref, $example);
        }

        return $example;
    }
}
