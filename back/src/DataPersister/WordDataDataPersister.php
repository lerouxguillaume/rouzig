<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\DataTransformer\WordDataTransformer;
use App\Dto\WordDto;
use App\Entity\WordObject;
use App\Service\WordServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class WordDataDataPersister implements ContextAwareDataPersisterInterface
{
    /** @var WordDataTransformer */
    private $wordDataTransformer;

    /** @var WordServiceInterface */
    private $wordService;

    /**
     * @param Request
     */
    private $request;

    /**
     * WordDataDataPersister constructor.
     * @param WordDataTransformer $wordDataTransformer
     * @param WordServiceInterface $wordService
     * @param RequestStack $request
     */
    public function __construct(
        WordDataTransformer $wordDataTransformer,
        WordServiceInterface $wordService,
        RequestStack $request
    ) {
        $this->wordDataTransformer = $wordDataTransformer;
        $this->wordService = $wordService;
        $this->request = $request->getCurrentRequest();
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof WordDto;
    }

    public function persist($data, array $context = [])
    {
         $wordObject = $this->wordDataTransformer->transform($data, WordObject::class);

         $operation = $context['item_operation_name'] ?? $context['collection_operation_name'] ?? null;

        if ($operation === 'PATCH' && !empty($id = $this->request->get('id'))) {
            $this->wordService->update($id, $wordObject);
        } else {
            $this->wordService->save($wordObject);
        }

        return $this->wordDataTransformer->transform($wordObject, WordDto::class);
    }


    public function remove($data, array $context = [])
    {
        $wordObject = $this->wordDataTransformer->transform($data, WordObject::class);

        $this->wordService->delete($wordObject);

        return $data;
    }
}