<?php

namespace App\Tests\api;

use App\Entity\User;
use App\Tests\ApiTester;

class GetWordCest
{
    public function createUserViaAPI(ApiTester $I)
    {
        $I->have(User::class);

        $I->sendGet('/words', [
            'search' => 'danser'
        ]);
        $I->seeResponseCodeIs(200); // 200
        $I->seeResponseIsJson();
    }
}