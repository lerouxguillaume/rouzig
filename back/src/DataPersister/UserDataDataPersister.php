<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\User;
use App\Event\UserEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserDataDataPersister implements ContextAwareDataPersisterInterface
{
    /** @var EventDispatcherInterface */
    private $dispatcher;

    /**
     * UserDataDataPersister constructor.
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
        EventDispatcherInterface $dispatcher
    )
    {
        $this->dispatcher = $dispatcher;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
    }

    public function persist($data, array $context = [])
    {
        $this->dispatcher->dispatch(new UserEvent($data), UserEvent::REGISTER);

        return $data;
    }

    public function remove($data, array $context = [])
    {
        $this->dispatcher->dispatch(new UserEvent($data), UserEvent::DELETE);

        return;
    }
}