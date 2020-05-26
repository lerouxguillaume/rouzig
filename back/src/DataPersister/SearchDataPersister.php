<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Dto\SearchDto;
use App\Dto\UserDto;
use App\Entity\User;
use App\Event\UserEvent;
use App\Handler\UserDtoHandler;
use App\Handler\TranslationDtoHandler;
use App\Service\SearchService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SearchDataPersister implements ContextAwareDataPersisterInterface
{
    /** @var SearchService */
    private $searchService;

    /**
     * SearchDataPersister constructor.
     * @param SearchService $searchService
     */
    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }


    public function supports($data, array $context = []): bool
    {
        return $data instanceof SearchDto;
    }

    public function persist($data, array $context = [])
    {
        throw new MethodNotAllowedHttpException(['GET','DELETE']);
    }

    /**
     * @param SearchDto $data
     * @param array $context
     */
    public function remove($data, array $context = [])
    {
        $this->searchService->delete($data->getText());
    }
}