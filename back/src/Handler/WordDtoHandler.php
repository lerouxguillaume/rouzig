<?php

namespace App\Handler;

use App\Dto\WordDto;
use App\EventSuscriber\WordWorkflow;
use App\Factory\WordFactory;
use App\Service\WordServiceInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Workflow\Registry;

class WordDtoHandler
{
    /** @var WordServiceInterface */
    private $wordService;

    /** @var Registry */
    private $workflowRegistry;

    /**
     * WordDtoHandler constructor.
     * @param WordServiceInterface $wordService
     * @param Registry $workflowRegistry
     */
    public function __construct(WordServiceInterface $wordService, Registry $workflowRegistry)
    {
        $this->wordService = $wordService;
        $this->workflowRegistry = $workflowRegistry;
    }

    public function create(WordDto $wordDto)
    {
        $word = WordFactory::create($wordDto->getWordType());
        $word->populateFromDto($wordDto);

        $workflow = $this->workflowRegistry->get($word);

        if (! $workflow->can($word, WordWorkflow::TRANSITION_CREATE)) {
            throw new AccessDeniedHttpException();
        }

        $workflow->apply($word, WordWorkflow::TRANSITION_CREATE);

        $this->wordService->save($word);

        return $word->getDto();
    }

    public function update(int $id, WordDto $wordDto)
    {
        $word = $this->wordService->findById($id);

        $updatedWord = $word->populateFromDto($wordDto);

        $workflow = $this->workflowRegistry->get($updatedWord);

        if (! $workflow->can($updatedWord, WordWorkflow::TRANSITION_UPDATE)) {
            throw new AccessDeniedHttpException();
        }

        $workflow->apply($updatedWord, WordWorkflow::TRANSITION_UPDATE);

        $this->wordService->save($updatedWord);

        return $updatedWord->getDto();
    }

    public function delete(WordDto $wordDto)
    {
        $word = $this->wordService->findById($wordDto->getId());

        $workflow = $this->workflowRegistry->get($word);

        if (! $workflow->can($word, WordWorkflow::TRANSITION_DELETE)) {
            throw new AccessDeniedHttpException();
        }

        $workflow->apply($word, WordWorkflow::TRANSITION_DELETE);

        $this->wordService->delete($word);

        return $word->getDto();
    }

    public function review(WordDto $wordDto)
    {
        $word = $this->wordService->findById($wordDto->getId());

        $workflow = $this->workflowRegistry->get($word);

        if (! $workflow->can($word, WordWorkflow::TRANSITION_REVIEW)) {
            throw new AccessDeniedHttpException();
        }

        $workflow->apply($word, WordWorkflow::TRANSITION_REVIEW);

        $this->wordService->save($word);

        return $word->getDto();
    }

    public function validate(WordDto $wordDto)
    {
        $word = $this->wordService->findById($wordDto->getId());

        $workflow = $this->workflowRegistry->get($word);

        if (! $workflow->can($word, WordWorkflow::TRANSITION_ACCEPT)) {
            throw new AccessDeniedHttpException();
        }

        $workflow->apply($word, WordWorkflow::TRANSITION_ACCEPT);

        $this->wordService->save($word);

        return $word->getDto();
    }

    public function reject(WordDto $wordDto)
    {
        $word = $this->wordService->findById($wordDto->getId());

        $workflow = $this->workflowRegistry->get($word);

        if (! $workflow->can($word, WordWorkflow::TRANSITION_REJECT)) {
            throw new AccessDeniedHttpException();
        }

        $workflow->apply($word, WordWorkflow::TRANSITION_REJECT);

        $this->wordService->save($word);

        return $word->getDto();
    }
}