<?php

namespace App\Tests\api;

use App\Entity\User;
use App\Tests\ApiTester;
use App\Tests\Helper\Provider\ExampleProvider;
use App\Tests\Helper\Provider\TranslationProvider;
use App\Tests\Helper\Provider\UserProvider;
use App\Tests\Helper\Provider\WordProvider;
use Faker\Factory;
use Faker\Generator;

class UserCest
{
    private $passwordEncoder;

    public function _before(ApiTester $I)
    {
        $this->passwordEncoder = $I->grabService('security.password_encoder');
    }

    public function createUser(ApiTester $I)
    {
        /** @var User $user */
        $user = $this->getFaker()->user();

        $user->setPlainPassword('password');

        $I->haveHttpHeader('Accept', 'application/vnd.api+json');
        $I->haveHttpHeader('Content-Type', 'application/ld+json');
        $I->sendPOST('/api/users', $this->userToJson($user));
        $I->seeResponseCodeIs(201); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'username' => $user->getUsername()
        ]);
        $objectId = $I->grabDataFromResponseByJsonPath('$.._id')[0];
        $I->seeInRepository(User::class, ['id'=>$objectId, 'email' => $user->getEmail(), 'isActive' => false]);
    }

    public function activateUser(ApiTester $I)
    {
        $token = $this->getFaker()->bankAccountNumber;

        /** @var User $user */
        $user = $this->getFaker()->user();

        $user->setIsActive(false);
        $user->setToken($token);

        $I->haveInRepository($user);

        $I->haveHttpHeader('Accept', 'application/vnd.api+json');
        $I->haveHttpHeader('Content-Type', 'application/ld+json');
        $I->sendPOST('/api/users/activate', ['token' => $token]);
        $I->seeResponseCodeIs(204); // 200

        $I->refreshEntities($user);

        $I->assertTrue($user->isActive());
        $I->assertEmpty($user->getToken());
    }

    public function resetPassword(ApiTester $I)
    {
        /** @var User $user */
        $user = $this->getFaker()->user();

        $user->setIsActive(false);

        $I->haveInRepository($user);

        $I->haveHttpHeader('Accept', 'application/vnd.api+json');
        $I->haveHttpHeader('Content-Type', 'application/ld+json');
        $I->sendPOST('/api/users/reset-password', ['email' => $user->getEmail()]);
        $I->seeResponseCodeIs(204); // 200

        $I->refreshEntities($user);

        $I->assertNotEmpty($user->getToken());
    }

    public function newPassword(ApiTester $I)
    {
        $token = $this->getFaker()->bankAccountNumber;

        /** @var User $user */
        $user = $this->getFaker()->user();

        $user->setIsActive(false);
        $user->setToken($token);
        $user->setPlainPassword('azerty');
        $oldPassword = $user->getPassword();
        $I->haveInRepository($user);

        $I->haveHttpHeader('Accept', 'application/vnd.api+json');
        $I->haveHttpHeader('Content-Type', 'application/ld+json');
        $I->sendPOST('/api/users/new-password', ['token' => $user->getToken(), 'password' => $user->getPlainPassword()]);
        $I->seeResponseCodeIs(201); // 200

        $I->refreshEntities($user);

        $I->assertEmpty($user->getToken());
        $I->assertNotEquals($oldPassword, $user->getPassword());
    }

    public function deleteUser(ApiTester $I)
    {
        /** @var User $user */
        $user = $this->getFaker()->user();
        $user->setIsActive(true);

        $I->haveInRepository($user);

        $I->sendDELETE('/api/users/' . $user->getId());
        $I->seeResponseCodeIs(204); // 204

        $I->refreshEntities($user);

        $I->assertTrue($user->isDeleted());
        $I->assertFalse($user->isActive());
    }

    private function userToJson(User $user): string
    {
        return json_encode([
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password' => $user->getPlainPassword(),
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