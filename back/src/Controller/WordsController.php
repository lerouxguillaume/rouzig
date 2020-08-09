<?php

namespace App\Controller;

use App\Entity\WordObject;
use App\Service\WordService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;

/**
 * Class WordsController
 * @package App\Controller
 * @OA\Tag(name="Words")
 */
class WordsController extends AbstractFOSRestController
{
    private WordService $wordsService;

    /**
     * WordsController constructor.
     * @param WordService $wordsService
     */
    public function __construct(WordService $wordsService)
    {
        $this->wordsService = $wordsService;
    }

    /**
     * @param $id
     * @REST\Get("/words/{id}")
     * @REST\View(StatusCode = 200)
     */
    public function getAction($id): ?WordObject
    {
        return $this->wordsService->find($id);
    }

    /**
     * @Rest\Get("/words")
     * @REST\View(StatusCode = 200)
     * @OA\Response(
     *     response=200,
     *     description="Returns the rewards of an user",
     * )
     */
    public function getAllAction():array
    {
        return $this->wordsService->findBy([]);
    }

    /**
     * @Rest\Post("/words")
     * @REST\View(StatusCode = 201)
     */
    public function postAction()
    {

    }

    /**
     * @Rest\Put("/words/{id}")
     * @REST\View(StatusCode = 200)
     */
    public function putAction($id)
    {

    }

    /**
     * @Rest\Patch("/words/{id}")
     * @REST\View(StatusCode = 200)
     */
    public function patchAction($id)
    {

    }

    /**
     * @Rest\Delete("/words/{id}")
     * @REST\View(StatusCode = 200)
     */
    public function deleteAction($id)
    {

    }
}