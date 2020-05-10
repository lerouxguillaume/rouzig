<?php

namespace App\Controller;

use App\Dto\WordDto;
use App\Entity\WordObject;
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
        /** @var WordObject $word */
        if (empty($word = $this->em->getRepository(WordObject::class)->find($wordId))) {
            throw new NotFoundHttpException();
        }

        $word->setStatus(WordObject::STATUS_APPROVED);

        $this->em->persist($word);
        $this->em->flush();

        return new Response();
    }
}