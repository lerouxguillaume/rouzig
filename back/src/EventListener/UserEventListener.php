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
        $this->mailService->sendEmailValidation($event->getUser());
        dump($event);die();
    }
}