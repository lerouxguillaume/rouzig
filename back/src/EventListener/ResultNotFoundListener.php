<?php


namespace App\EventListener;


use App\Entity\Search;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class ResultNotFoundListener
{
    /** @var EntityManagerInterface */
    private $em;

    /**
     * ResultNotFoundListener constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function onKernelView(RequestEvent $event)
    {
        if (!$event->isMasterRequest()) {
            // don't do anything if it's not the master request
            return;
        }
        $request = $event->getRequest();
        if ($request->attributes->get('_route') !== "api_words_get_collection") {
            return;
        }

        /** @var Paginator $data */
        $data = $request->get('data');
        if ($data->count() === 0) {
            $searchedWord = $request->query->get('text');
            $search = $this->em->getRepository(Search::class)->findOneByText($searchedWord);
            if (empty($search)) {
                $search = new Search();
                $search
                    ->setText($searchedWord)
                ;
            }
            $search->countAdd();
            $this->em->persist($search);
            $this->em->flush();
        }
    }
}