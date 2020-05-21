<?php

namespace App\Tests\api;

use App\Entity\Translation;
use App\Entity\Word\Verb;
use App\Tests\ApiTester;
use App\Tests\Helper\Provider\TranslationProvider;
use App\Tests\Helper\Provider\UserProvider;
use Faker\Factory;
use Faker\Generator;

class WordCest
{
    private $passwordEncoder;

    public function _before(ApiTester $I)
    {
        $this->passwordEncoder = $I->grabService('security.password_encoder');
    }

    public function searchWord(ApiTester $I)
    {
        /** @var Translation $translation */
        $translation = $this->getFaker()->translation();

        $I->haveInRepository($translation);

        $I->sendGet('/api/words', [
            'search' => $translation->getOriginalWord()->getText()
        ]);
        $I->seeResponseCodeIs(200); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'word' => $translation->getOriginalWord()->getText()
        ]);

        $wordNotExistent = 'AZERTYUIOP';

        $I->dontSeeInRepository(Verb::class, ['text' => $wordNotExistent]);

        $I->sendGet('/api/words', [
            'search' => $wordNotExistent
        ]);
        $I->seeResponseCodeIs(200); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'hydra:totalItems' => 0
        ]);
    }

    private function getFaker(): Generator
    {
        $faker = Factory::create();
        $faker->addProvider(new UserProvider($faker, $this->passwordEncoder));
        $faker->addProvider(new TranslationProvider($faker));
        return $faker;
    }
}