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

        switch ($operation) {
            case 'PATCH':
                $id = $this->request->get('id');
                return $this->wordDtoHandler->update($id, $data);
            case 'POST':
                return $this->wordDtoHandler->create($data);
            case 'post_review':
                return $this->wordDtoHandler->review($data);
            case 'post_validate':
                return $this->wordDtoHandler->validate($data);
            case 'post_reject':
                return $this->wordDtoHandler->reject($data);
        }

        return $data;
    }


    public function remove($data, array $context = [])
    {
        return $this->wordDtoHandler->delete($data);
    }
}