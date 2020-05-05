<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class UserEvent extends Event
{
    public const REGISTER = 'user.register';
    public const ACTIVATE = 'user.activate';
    public const DISABLE = 'user.disable';
    public const DELETE = 'user.delete';

    /** @var User */
    protected $user;

    /**
     * UserEvent constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}