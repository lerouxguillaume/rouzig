<?php

namespace App\Tests\api;

use App\Entity\Translation;
use App\Entity\Word\Verb;
use App\Entity\WordObject;
use App\Tests\Helper\Provider\ExampleProvider;
use App\Tests\Helper\Provider\TranslationProvider;
use App\Tests\Helper\Provider\WordProvider;
use Faker\Factory;
use Faker\Generator;
use App\Tests\ApiTester;

class WordCest
{
    public function searchWord(ApiTester $I)
    {
        /** @var WordObject $word */
        $word = $this->getFaker()->verb();

        $I->haveInRepository($word);

        $I->haveHttpHeader('Accept', 'application/vnd.api+json');
        $I->sendGet('/words', [
            'search' => $word->getText()
        ]);
        $I->seeResponseCodeIs(200); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'word' => $word->getText()
        ]);

        $wordNotExistent = $this->getFaker()->unique()->word;

        $I->dontSeeInRepository(Verb::class, ['text' => $wordNotExistent]);

        $I->haveHttpHeader('Accept', 'application/vnd.api+json');
        $I->sendGet('/words', [
            'search' => $wordNotExistent
        ]);
        $I->seeResponseCodeIs(200); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'meta' => [
                'totalItems' => 0
            ]
        ]);
    }

    public function createWord(ApiTester $I)
    {
        /** @var WordObject $word */
        $word = $this->getFaker()->verb();

        $I->dontSeeInRepository(Verb::class, ['text' => $word->getText()]);

        $I->haveHttpHeader('Accept', 'application/vnd.api+json');
        $I->haveHttpHeader('Content-Type', 'application/ld+json');
        $I->sendPOST('/words', $this->wordToJson($word));
        $I->seeResponseCodeIs(201); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'word' => $word->getText()
        ]);
    }

    public function patchWord(ApiTester $I)
    {
        /** @var WordObject $word */
        $word = $this->getFaker()->verb();

        $I->haveInRepository($word);

        $word->setText($this->getFaker()->unique()->word);

        $I->haveHttpHeader('Accept', 'application/vnd.api+json');
        $I->haveHttpHeader('Content-Type', 'application/vnd.api+json');
        $I->sendPATCH('/words/'.$word->getId(), $this->wordToJson($word));
        $I->seeResponseCodeIs(200); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'word' => $word->getText()
        ]);

        $I->seeInRepository(Verb::class, ['id'=>$word->getId(), 'text' => $word->getText()]);

    }

    private function wordToJson(WordObject $wordObject): array
    {
        $translations = [];
        /** @var Translation $translation */
        foreach ($wordObject->getTranslations() as $translation) {
            $translations[] = [
                'word' => $translation->getText(),
                'language' => $translation->getLanguage(),
                'description' => $translation->getDescription()
            ];
        }

        return [
            'word' => $wordObject->getText(),
            'language' => $wordObject->getLanguage(),
            'wordType' => 'verb',
            'translations' => $translations
        ];
    }

    private function getFaker(): Generator
    {
        $faker = Factory::create();
        $faker->addProvider(new WordProvider(
                $faker,
                new TranslationProvider($faker, new ExampleProvider($faker))
            )
        );
        return $faker;
    }
}