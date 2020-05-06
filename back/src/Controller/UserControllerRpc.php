<?php

namespace App\Controller;

use App\Entity\User;
use App\Event\UserEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/users")
 *
 * Class WordsControllerRpc
 * @package App\Controller
 */
class UserControllerRpc extends AbstractController
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var EventDispatcherInterface */
    private $dispatcher;

    /**
     * UserControllerRpc constructor.
     * @param EntityManagerInterface $em
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EntityManagerInterface $em, EventDispatcherInterface $dispatcher)
    {
        $this->em = $em;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @Route("/validate", name="validate_user", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function validateAction(Request $request)
    {
        $content = json_decode($request->getContent());

        if (empty($content) || empty($token = $content->token)) {
            throw new BadRequestHttpException('Missing token');
        }

        /** @var $user User */
        if (empty($user = $this->em->getRepository(User::class)->findOneByToken($token))) {
            throw new NotFoundHttpException('Token not found');
        }

        $this->dispatcher->dispatch(new UserEvent($user), UserEvent::ACTIVATE);

        return new Response();
    }

    /**
     * @Route("/reset-password", name="resetPassword", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function resetPassword(Request $request)
    {
        $content = json_decode($request->getContent());

        if (empty($content) || empty($email = $content->email)) {
            throw new BadRequestHttpException('Missing email');
        }

        /** @var $user User */
        if (empty($user = $this->em->getRepository(User::class)->findOneByEmail($email))) {
            return new Response(); //Do not reveal if this email exist
        }

        $this->dispatcher->dispatch(new UserEvent($user), UserEvent::RESET_PASSWORD);

        return new Response();
    }

    /**
     * @Route("/new-password", name="newPassword", methods={"POST"})
     * @param int $wordId
     */
    public function newPasswordAction(Request $request)
    {
        $content = json_decode($request->getContent());

        if (empty($content) || empty($token = $content->token) || empty($password = $content->password)) {
            throw new BadRequestHttpException('Missing parameter');
        }


        /** @var $user User */
        if (empty($user = $this->em->getRepository(User::class)->findOneByToken($token))) {
            throw new NotFoundHttpException('Token not found');
        }

        $user->setPassword($password);

        $this->dispatcher->dispatch(new UserEvent($user), UserEvent::NEW_PASSWORD);

        return new Response();
    }
}