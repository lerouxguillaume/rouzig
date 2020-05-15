<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Dto\WordDto;
use App\Handler\WordDtoHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class WordDataPersister implements ContextAwareDataPersisterInterface
{
    /** @var Request */
    private $request;

   /** @var WordDtoHandler */
    private $wordDtoHandler;

    /**
     * WordDataDataPersister constructor.
     * @param RequestStack $request
     * @param WordDtoHandler $wordDtoHandler
     */
    public function __construct(RequestStack $request, WordDtoHandler $wordDtoHandler)
    {
        $this->request = $request->getCurrentRequest();
        $this->wordDtoHandler = $wordDtoHandler;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof WordDto;
    }

    public function persist($data, array $context = [])
    {
         $operation = $context['item_operation_name'] ?? $context['collection_operation_name'] ?? null;

        if ($operation === 'PATCH' && !empty($id = $this->request->get('id'))) {
            $result = $this->wordDtoHandler->update($id, $data);
        } else {
            $result = $this->wordDtoHandler->create($data);
        }

        return $result;
    }


    public function remove($data, array $context = [])
    {
        return $this->wordDtoHandler->delete($data);
    }
}