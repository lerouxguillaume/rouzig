<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Dto\UserDto;
use App\Entity\User;
use App\Event\UserEvent;
use App\Handler\UserDtoHandler;
use App\Handler\TranslationDtoHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserDataPersister implements ContextAwareDataPersisterInterface
{
    /** @var Request */
    private $request;

    /** @var UserDtoHandler */
    private $userDtoHandler;

    /**
     * UserDataPersister constructor.
     * @param RequestStack $request
     * @param UserDtoHandler $userDtoHandler
     */
    public function __construct(RequestStack $request, UserDtoHandler $userDtoHandler)
    {
        $this->request = $request->getCurrentRequest();
        $this->userDtoHandler = $userDtoHandler;
    }


    public function supports($data, array $context = []): bool
    {
        return $data instanceof UserDto;
    }

    public function persist($data, array $context = [])
    {
        $operation = $context['item_operation_name'] ?? $context['collection_operation_name'] ?? null;

        switch ($operation) {
            case 'PATCH':
                $id = $this->request->get('id');
                return $this->userDtoHandler->update($id, $data);
            case 'POST':
                return $this->userDtoHandler->create($data);
            case 'POST_ACTIVATE':
                return $this->userDtoHandler->validate($data);
            case 'POST_RESET_PASSWORD':
                return $this->userDtoHandler->resetPassword($data);
            case 'POST_NEW_PASSWORD':
                return $this->userDtoHandler->newPassword($data);
        }

        return $data;
    }

    public function remove($data, array $context = [])
    {
        return $this->userDtoHandler->delete($data);
    }
}