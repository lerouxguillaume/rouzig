<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Dto\TranslationDto;
use App\Handler\TranslationDtoHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class TranslationDataPersister implements ContextAwareDataPersisterInterface
{
    /** @var Request */
    private $request;

   /** @var TranslationDtoHandler */
    private $translationDtoHandler;

    /**
     * WordDataDataPersister constructor.
     * @param RequestStack $request
     * @param TranslationDtoHandler $translationDtoHandler
     */
    public function __construct(RequestStack $request, TranslationDtoHandler $translationDtoHandler)
    {
        $this->request = $request->getCurrentRequest();
        $this->translationDtoHandler = $translationDtoHandler;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof TranslationDto;
    }

    public function persist($data, array $context = [])
    {
         $operation = $context['item_operation_name'] ?? $context['collection_operation_name'] ?? null;

        switch ($operation) {
            case 'PATCH':
                $id = $this->request->get('id');
                return $this->translationDtoHandler->update($id, $data);
            case 'POST':
                return $this->translationDtoHandler->create($data);
            case 'post_review':
                return $this->translationDtoHandler->review($data);
            case 'post_validate':
                return $this->translationDtoHandler->validate($data);
            case 'post_reject':
                return $this->translationDtoHandler->reject($data);
        }

        return $data;
    }


    public function remove($data, array $context = [])
    {
        return $this->translationDtoHandler->delete($data);
    }
}