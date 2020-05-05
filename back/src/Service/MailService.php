<?php


namespace App\Service;


use App\Entity\User;
use Twig\Environment;

class MailService
{
    /** @var \Swift_Mailer */
    private $mailer;

    /** @var Environment */
    private $renderer;

    /**
     * MailService constructor.
     * @param \Swift_Mailer $mailer
     * @param Environment $renderer
     */
    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function sendEmailValidation(User $user)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('guillaume.couloigner@gmail.com')
            ->setTo('guillaume@leroux.email')
            ->setBody($this->renderer->render('email/email_validation.html.twig', ['user' =>$user]), 'text/html')
        ;
        $this->mailer->send($message);

    }
}