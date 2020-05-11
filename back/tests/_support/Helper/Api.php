<?php
namespace App\Tests\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use App\Entity\User;
use Codeception\Module;

class Api extends Module
{
    public function _beforeSuite($settings = array())
    {
        $factory = $this->getModule('DataFactory');
        $factory->_define(User::class, [
            'username' => 'undique:text',
            'email' => 'unique:email',
            'password' => 'password',
            'is_active' => true
        ]);
    }
}
