<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Security;

class UserController
{
    /** @var Security */
    private $security;

    /**
     * UserController constructor.
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function __invoke($data)
    {
        return $data;
    }

    public function getMe() {
        /** @var $user User */
        if (empty($user = $this->security->getUser())) {
            throw new NotFoundHttpException();
        }
        return $user->getDto();
    }
}