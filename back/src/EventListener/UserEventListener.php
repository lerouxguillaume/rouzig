<?php

namespace App\EventListener;

use App\Event\UserEvent;
use App\Service\MailService;

class UserEventListener
{
    /** @var MailService */
    private $mailService;

    /**
     * UserEventListener constructor.
     * @param MailService $mailService
     */
    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function onUserRegister(UserEvent $event)
    {
        //@TODO: create token and handle all of that
        $this->mailService->sendEmailValidation($event->getUser());
    }
}