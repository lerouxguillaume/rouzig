<?php

namespace App\Tests\api;

use App\Entity\User;
use App\Tests\ApiTester;
use App\Tests\Helper\Provider\ExampleProvider;
use App\Tests\Helper\Provider\TranslationProvider;
use App\Tests\Helper\Provider\UserProvider;
use App\Tests\Helper\Provider\WordProvider;
use Doctrine\Common\Collections\Criteria;
use Faker\Factory;
use Faker\Generator;
use Trikoder\Bundle\OAuth2Bundle\Model\AccessToken;
use Trikoder\Bundle\OAuth2Bundle\Model\Client;

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

    public function login(ApiTester $I)
    {
        $plainPassword = 'password';
        /** @var User $user */
        $user = $this->getFaker()->user($plainPassword);

        $user->setIsActive(true);

        $I->haveInRepository($user);
        /** @var Client $client */
        $client = $I->grabEntityFromRepository(Client::class, [
            Criteria::expr()->contains('grants', 'password'),
        ]);
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amHttpAuthenticated(
            $client->getIdentifier(),
            $client->getSecret()
        );
        $I->sendPOST('/token', [
            'grant_type' => 'password',
            'username' => $user->getUsername(),
            'password' => $plainPassword
        ]);
        $I->seeResponseCodeIs(200); // 200
        $I->seeResponseIsJson();
        $token = $I->grabDataFromResponseByJsonPath('$..access_token')[0];

        $I->assertNotEmpty($token);
        $I->seeInRepository(AccessToken::class, ['userIdentifier' => $user->getUsername()]);

//        $I->haveHttpHeader('Authorization', '');
//        $I->haveHttpHeader('Accept', 'application/vnd.api+json');
//        $I->haveHttpHeader('Content-Type', 'application/ld+json');
//        $I->sendGET('/api/users/me');
//        $I->seeResponseCodeIs(200); // 200
//        $I->seeResponseIsJson();
//        $I->seeResponseContainsJson([
//            'username' => $user->getUsername()
//        ]);
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
        return $faker;
    }
}