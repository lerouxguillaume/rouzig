<?php

namespace App\Handler;

use App\Dto\TranslationDto;
use App\Entity\Translation;
use App\EventSuscriber\WordWorkflow;
use App\Service\TranslationService;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Workflow\Registry;

class TranslationDtoHandler
{
    /** @var TranslationService */
    private $translationService;

    /** @var Registry */
    private $workflowRegistry;

    /**
     * WordDtoHandler constructor.
     * @param TranslationService $translationService
     * @param Registry $workflowRegistry
     */
    public function __construct(TranslationService $translationService, Registry $workflowRegistry)
    {
        $this->translationService = $translationService;
        $this->workflowRegistry = $workflowRegistry;
    }

    public function create(TranslationDto $translationDto)
    {
        $translation = new Translation();
        $translation->populateFromDto($translationDto);

        $workflow = $this->workflowRegistry->get($translation);

        if (! $workflow->can($translation, WordWorkflow::TRANSITION_CREATE)) {
            throw new AccessDeniedHttpException();
        }

        $workflow->apply($translation, WordWorkflow::TRANSITION_CREATE);

        $this->translationService->save($translation);

        return $translation->getDto();
    }

    public function update(int $id, TranslationDto $translationDto)
    {
        $translation = $this->translationService->findById($id);

        $updatedTranslation = $translation->populateFromDto($translationDto);

        $workflow = $this->workflowRegistry->get($updatedTranslation);

        if (! $workflow->can($updatedTranslation, WordWorkflow::TRANSITION_UPDATE)) {
            throw new AccessDeniedHttpException();
        }

        $workflow->apply($updatedTranslation, WordWorkflow::TRANSITION_UPDATE);

        $this->translationService->save($updatedTranslation);

        return $updatedTranslation->getDto();
    }

    public function delete(TranslationDto $translationDto)
    {
        $translation = $this->translationService->findById($translationDto->getId());

        $workflow = $this->workflowRegistry->get($translation);

        if (! $workflow->can($translation, WordWorkflow::TRANSITION_DELETE)) {
            throw new AccessDeniedHttpException();
        }

        $workflow->apply($translation, WordWorkflow::TRANSITION_DELETE);

        $this->translationService->delete($translation);

        return $translation->getDto();
    }

    public function review(TranslationDto $translationDto)
    {
        $translation = $this->translationService->findById($translationDto->getId());

        $workflow = $this->workflowRegistry->get($translation);

        if (! $workflow->can($translation, WordWorkflow::TRANSITION_REVIEW)) {
            throw new AccessDeniedHttpException();
        }

        $workflow->apply($translation, WordWorkflow::TRANSITION_REVIEW);

        $this->translationService->save($translation);

        return $translation->getDto();
    }

    public function validate(TranslationDto $translationDto)
    {
        $translation = $this->translationService->findById($translationDto->getId());

        $workflow = $this->workflowRegistry->get($translation);

        if (! $workflow->can($translation, WordWorkflow::TRANSITION_ACCEPT)) {
            throw new AccessDeniedHttpException();
        }

        $workflow->apply($translation, WordWorkflow::TRANSITION_ACCEPT);

        $this->translationService->save($translation);

        return $translation->getDto();
    }

    public function reject(TranslationDto $translationDto)
    {
        $translation = $this->translationService->findById($translationDto->getId());

        $workflow = $this->workflowRegistry->get($translation);

        if (! $workflow->can($translation, WordWorkflow::TRANSITION_REJECT)) {
            throw new AccessDeniedHttpException();
        }

        $workflow->apply($translation, WordWorkflow::TRANSITION_REJECT);

        $this->translationService->save($translation);

        return $translation->getDto();
    }
}