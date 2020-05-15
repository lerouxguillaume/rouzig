<?php

namespace App\Tests\api;

use App\Entity\Example;
use App\Entity\Translation;
use App\Entity\Word\Verb;
use App\Entity\WordObject;
use App\Tests\ApiTester;
use App\Tests\Helper\Provider\ExampleProvider;
use App\Tests\Helper\Provider\TranslationProvider;
use App\Tests\Helper\Provider\UserProvider;
use App\Tests\Helper\Provider\WordProvider;
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
        /** @var WordObject $word */
        $word = $this->getFaker()->verb();

        $I->haveInRepository($word);

        $I->haveHttpHeader('Accept', 'application/vnd.api+json');
        $I->sendGet('/api/words', [
            'search' => $word->getText()
        ]);
        $I->seeResponseCodeIs(200); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'word' => $word->getText()
        ]);

        $wordNotExistent = 'AZERTYUIOP';

        $I->dontSeeInRepository(Verb::class, ['text' => $wordNotExistent]);

        $I->haveHttpHeader('Accept', 'application/vnd.api+json');
        $I->sendGet('/api/words', [
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

        $I->haveHttpHeader('Accept', 'application/vnd.api+json');
        $I->haveHttpHeader('Content-Type', 'application/ld+json');
        $I->sendPOST('/api/words', $this->wordToJson($word));
        $I->seeResponseCodeIs(201); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'word' => $word->getText()
        ]);
        $objectId = $I->grabDataFromResponseByJsonPath('$.._id')[0];
        $I->seeInRepository(Verb::class, ['id'=>$objectId, 'text' => $word->getText()]);
    }

    public function patchWord(ApiTester $I)
    {
        /** @var WordObject $word */
        $word = $this->getFaker()->verb();

        $I->haveInRepository($word);

        $word->setText($this->getFaker()->unique()->word);

        $I->haveHttpHeader('Accept', 'application/vnd.api+json');
        $I->haveHttpHeader('Content-Type', 'application/merge-patch+json');
        $I->sendPATCH('/api/words/'.$word->getId(), $this->wordToJson($word));
        $I->seeResponseCodeIs(200); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'word' => $word->getText()
        ]);

        $I->seeInRepository(Verb::class, ['id'=>$word->getId(), 'text' => $word->getText()]);

        /** @var Translation $translation */
        $translation = current($word->getTranslations());
        $translation->setText($this->getFaker()->unique()->word);
        /** @var Example $example */
        $example = current($translation->getExamples());
        $example->setToText($this->getFaker()->unique()->text);
        $I->haveHttpHeader('Content-Type', 'application/merge-patch+json');
        $I->sendPATCH('/api/words/'.$word->getId(), $this->wordToJson($word));
        $I->seeResponseCodeIs(200); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'word' => $word->getText()
        ]);
        $I->seeResponseContainsJson([
            'translations' => [
                'word' => $translation->getText()
            ]
        ]);
        $I->seeResponseContainsJson([
            'examples' => [
                'toText' => $example->getToText()
            ]
        ]);
    }

    public function deleteWord(ApiTester $I)
    {
        /** @var WordObject $word */
        $word = $this->getFaker()->verb();

        $I->haveInRepository($word);

        $I->sendDELETE('/api/words/' . $word->getId());
        $I->seeResponseCodeIs(204); // 204

        $I->refreshEntities($word);

        $I->assertTrue($word->isDeleted());
        }

    private function wordToJson(WordObject $wordObject): string
    {
        $translations = [];
        /** @var Translation $translation */
        foreach ($wordObject->getTranslations() as $translation) {

            $examples = [];
            /** @var Example $example */
            foreach ($translation->getExamples() as $example) {
                $examples[] = [
                    'id' => $example->getId(),
                    'toText' => $example->getToText(),
                    'fromText' => $example->getFromText(),
                ];
            }

            $translations[] = [
                'id' => $translation->getId(),
                'word' => $translation->getText(),
                'language' => $translation->getLanguage(),
                'description' => $translation->getDescription(),
                'examples'=> $examples
            ];
        }

        return json_encode([
            'word' => $wordObject->getText(),
            'language' => $wordObject->getLanguage(),
            'wordType' => 'verb',
            'translations' => $translations
        ]);
    }

    private function getFaker(): Generator
    {
        $faker = Factory::create();
        $faker->addProvider(new UserProvider($faker, $this->passwordEncoder));
        $faker->addProvider(new WordProvider(
                $faker,
                new TranslationProvider($faker, new ExampleProvider($faker))
            )
        );
        return $faker;
    }
}