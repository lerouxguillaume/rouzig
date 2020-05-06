<?php


namespace App\Service;


use App\Entity\User;
use Twig\Environment;

class MailService
{
    const MAIL_SENDER = 'guillaume.couloigner@gmail.com';

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

    public function sendEmailValidation(User $user, string $redirectUrl): int
    {
        $message = (new \Swift_Message('Degemer mat !!!'))
            ->setFrom(self::MAIL_SENDER)
            ->setTo($user->getEmail())
            ->setBody($this->renderer->render(
                'email/email_validation.html.twig',
                ['user' =>$user, 'redirectUrl' => $redirectUrl]),
                'text/html'
            )
        ;
        return $this->mailer->send($message);
    }

    public function sendEmailResetPassword(User $user, string $redirectUrl): int
    {
        $message = (new \Swift_Message('Disonjet ho peux ho ger kuz'))
            ->setFrom(self::MAIL_SENDER)
            ->setTo($user->getEmail())
            ->setBody($this->renderer->render(
                'email/email_reset_password.html.twig',
                ['user' =>$user, 'redirectUrl' => $redirectUrl]),
                'text/html'
            )
        ;
        return $this->mailer->send($message);
    }
}