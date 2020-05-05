<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Word;
use App\Service\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/debug")
 *
 * Class DebugController
 * @package App\Controller
 */
class DebugController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var MailService */
    private $mailService;

    /**
     * DebugController constructor.
     * @param EntityManagerInterface $em
     * @param MailService $mailService
     */
    public function __construct(EntityManagerInterface $em, MailService $mailService)
    {
        $this->em = $em;
        $this->mailService = $mailService;
    }

    /**
     * @Route("/mail/{user_id}", requirements={"user_id"="\d+"}, name="debug_email", methods={"GET"})
     * @param int $user_id
     * @return Response
     */
//    public function validateAction(int $user_id)
//    {
//        /** @var User $user */
//        if (empty($user = $this->em->getRepository(User::class)->find($user_id))) {
//            throw new NotFoundHttpException();
//        }
//        $this->mailService->sendEmailValidation($user);
//        return $this->render('email/email_validation.html.twig', ['user' =>$user]);
//    }
}