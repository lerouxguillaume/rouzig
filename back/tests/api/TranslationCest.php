<?php

namespace App\Tests\api;

use App\Entity\Example;
use App\Entity\Translation;
use App\Entity\Word\Verb;
use App\Entity\WordObject;
use App\Enum\WordStatus;
use App\Tests\ApiTester;
use App\Tests\Helper\Provider\TranslationProvider;
use App\Tests\Helper\Provider\UserProvider;
use Faker\Factory;
use Faker\Generator;

class TranslationCest
{
    private $passwordEncoder;

    public function _before(ApiTester $I)
    {
        $this->passwordEncoder = $I->grabService('security.password_encoder');
    }

    public function createWord(ApiTester $I)
    {
        /** @var Translation $translation */
        $translation = $this->getFaker()->translation();

        $I->haveHttpHeader('Content-Type', 'application/ld+json');
        $I->sendPOST('/api/translations', $this->translationToJson($translation));
        $I->seeResponseCodeIs(201); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'word' => $translation->getOriginalWord()->getText()
        ]);
        $objectId = $I->grabDataFromResponseByJsonPath('$..id')[0];
        $I->seeInRepository(Translation::class, ['id'=>$objectId]);
    }

    public function patchWord(ApiTester $I)
    {
        /** @var Translation $translation */
        $translation = $this->getFaker()->translation();

        $I->haveInRepository($translation);

        $translation->getOriginalWord()->setText($this->getFaker()->unique()->word);

        $I->haveHttpHeader('Content-Type', 'application/merge-patch+json');
        $I->sendPATCH('/api/translations/'.$translation->getId(), $this->translationToJson($translation));
        $I->seeResponseCodeIs(200); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'word' => $translation->getOriginalWord()->getText()
        ]);

        $I->seeInRepository(Verb::class, ['id'=>$translation->getOriginalWord()->getId(), 'text' => $translation->getOriginalWord()->getText()]);

        $translation->getTranslatedWord()->setText($this->getFaker()->unique()->word);
        /** @var Example $example */
        $example = current($translation->getExamples());
        $example->setToText($this->getFaker()->unique()->text);

        $I->haveHttpHeader('Content-Type', 'application/merge-patch+json');
        $I->sendPATCH('/api/translations/'.$translation->getId(), $this->translationToJson($translation));
        $I->seeResponseCodeIs(200); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'originalWord' => [
                'word' => $translation->getOriginalWord()->getText()
            ]
        ]);
        $I->seeResponseContainsJson([
            'translatedWord' => [
                'word' => $translation->getTranslatedWord()->getText()
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
        /** @var Translation $translation */
        $translation = $this->getFaker()->translation();

        $I->haveInRepository($translation);

        $I->sendDELETE('/api/translations/' . $translation->getId());
        $I->seeResponseCodeIs(204); // 204

        $I->refreshEntities($translation);

        $I->assertTrue($translation->isDeleted());
    }

    public function reviewWord(ApiTester $I)
    {
        /** @var Translation $translation */
        $translation = $this->getFaker()->translation();

        $translation->setStatus(WordStatus::PENDING);

        $I->haveInRepository($translation);

        $I->haveHttpHeader('Content-Type', 'application/ld+json');
        $I->sendPOST('/api/translations/' . $translation->getId() . '/review');
        $I->seeResponseCodeIs(201); // 204

        $I->refreshEntities($translation);

        $I->assertEquals(WordStatus::REVIEW, $translation->getStatus());
    }

    public function validateWord(ApiTester $I)
    {
        /** @var Translation $translation */
        $translation = $this->getFaker()->translation();

        $translation->setStatus(WordStatus::REVIEW);

        $I->haveInRepository($translation);

        $I->haveHttpHeader('Content-Type', 'application/ld+json');
        $I->sendPOST('/api/translations/' . $translation->getId() . '/validate');
        $I->seeResponseCodeIs(201); // 204

        $I->refreshEntities($translation);

        $I->assertEquals(WordStatus::APPROVED, $translation->getStatus());
    }

    public function rejectWord(ApiTester $I)
    {
        /** @var Translation $translation */
        $translation = $this->getFaker()->translation();

        $translation->setStatus(WordStatus::REVIEW);

        $I->haveInRepository($translation);

        $I->haveHttpHeader('Content-Type', 'application/ld+json');
        $I->sendPOST('/api/translations/' . $translation->getId() . '/reject');
        $I->seeResponseCodeIs(201); // 204

        $I->refreshEntities($translation);

        $I->assertEquals(WordStatus::PENDING, $translation->getStatus());
    }

    private function translationToJson(Translation $translation): string
    {
        $examples = [];
        /** @var Example $example */
        foreach ($translation->getExamples() as $example) {
            $examples[] = [
                'id' => $example->getId(),
                'toText' => $example->getToText(),
                'fromText' => $example->getFromText(),
            ];
        }
        $originalWord = $translation->getOriginalWord();
        $translatedWord = $translation->getTranslatedWord();
        return json_encode([
            'id' => $translation->getId(),
            'originalWord' => $this->wordToArray($originalWord),
            'translatedWord' => $this->wordToArray($translatedWord),
            'examples'=> $examples
        ]);
    }

    private function wordToArray(WordObject $wordObject): array
    {
        return [
            'id' => $wordObject->getId(),
            'word' => $wordObject->getText(),
            'language' => $wordObject->getLanguage(),
            'description' => $wordObject->getDescription(),
            'wordType' => $wordObject->getType(),
        ];
    }

    private function getFaker(): Generator
    {
        $faker = Factory::create();
        $faker->addProvider(new UserProvider($faker, $this->passwordEncoder));
        $faker->addProvider(new TranslationProvider($faker));
        return $faker;
    }
}