<?php

namespace App\Controller;

use App\Entity\Word;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/words")
 *
 * Class WordsControllerRpc
 * @package App\Controller
 */
class WordsControllerRpc extends AbstractController
{
    /** @var EntityManagerInterface */
    private $em;

    /**
     * WordsControllerRpc constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/validate/{wordId}", requirements={"word"="\d+"}, name="validate_word", methods={"POST"})
     * @param int $wordId
     */
    public function validateAction(int $wordId)
    {
        /** @var Word $word */
        if (empty($word = $this->em->getRepository(Word::class)->find($wordId))) {
            throw new NotFoundHttpException();
        }

        $word->setStatus(Word::STATUS_APPROVED);

        $this->em->persist($word);
        $this->em->flush();

        return new Response();
    }
}