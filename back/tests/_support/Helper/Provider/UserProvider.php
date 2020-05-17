<?php

namespace App\Tests\Helper\Provider;

use App\Entity\User;
use Faker\Generator;
use Faker\Provider\Base;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserProvider extends Base
{
    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    /**
     * UserProvider constructor.
     * @param Generator $generator
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(Generator $generator, UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct($generator);
        $this->passwordEncoder = $passwordEncoder;
    }

    public function username() : string
    {
        return $this->generator->firstName;
    }

    public function email(): string
    {
        return $this->generator->safeEmail;
    }

    public function password(): string
    {
        return 'password';
    }

    public function user($password = null) : User
    {
        $user = new User();
        $user
            ->setUsername($this->username())
            ->setPassword($this->passwordEncoder->encodePassword($user, $password ?? $this->password()))
            ->setEmail($this->email())
            ->setIsActive(true)
        ;

        return $user;
    }
}