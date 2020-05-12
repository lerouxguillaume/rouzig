<?php
namespace App\Tests\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use App\Entity\User;
use App\Entity\Word\Verb;
use App\Entity\WordObject;
use Codeception\Module;
use League\FactoryMuffin\Faker\Facade as Faker;

class Api extends Module
{
    public function _beforeSuite($settings = array())
    {
        $symfony = $this->getModule('Symfony');

        $symfony->runSymfonyConsoleCommand('doctrine:database:drop',['--if-exists'=>true, '--force'=>true]);
        $symfony->runSymfonyConsoleCommand('doctrine:database:create');
        $symfony->runSymfonyConsoleCommand('doctrine:migrations:migrate', ['--no-interaction'=>true]);
    }
}
