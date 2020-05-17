<?php


namespace App\EventSuscriber;

use App\Entity\WordObject;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Workflow\Event\Event;

class WordWorkflow implements EventSubscriberInterface
{
    const NAME = 'words';

    const PLACE_CREATED = 'created';
    const PLACE_PENDING = 'pending';
    const PLACE_REVIEW = 'review';
    const PLACE_ACCEPTED = 'accepted';
    const PLACE_DELETED = 'deleted';

    const TRANSITION_CREATE = 'create';
    const TRANSITION_UPDATE = 'update';
    const TRANSITION_REVIEW = 'wait_for_review';
    const TRANSITION_ACCEPT = 'accept';
    const TRANSITION_REJECT = 'request_change';
    const TRANSITION_DELETE = 'delete';

    /** @var Security */
    private $securtiy;

    /**
     * WordWorkflow constructor.
     * @param Security $securtiy
     */
    public function __construct(Security $securtiy)
    {
        $this->securtiy = $securtiy;
    }

    public static function getSubscribedEvents()
    {
        return [
            'workflow.' . self::NAME . '.transition.' . self::TRANSITION_CREATE => 'onCreate',
            'workflow.' . self::NAME . '.transition.' . self::TRANSITION_UPDATE => 'onUpdate',
            'workflow.' . self::NAME . '.transition.' . self::TRANSITION_REVIEW => 'onReview',
            'workflow.' . self::NAME . '.transition.' . self::TRANSITION_ACCEPT => 'onAccept',
            'workflow.' . self::NAME . '.transition.' . self::TRANSITION_REJECT => 'onReject',
            'workflow.' . self::NAME . '.transition.' . self::TRANSITION_DELETE => 'onDelete',
        ];
    }

    public function onCreate(Event $event)
    {
        /** @var WordObject $word */
        $word = $event->getSubject();

        if ($user = $this->securtiy->getUser()) {
            $word->setAuthor($user);
        }
    }

    public function onUpdate(Event $event)
    {
    }

    public function onReview()
    {

    }

    public function onAccept(Event$event)
    {

    }

    public function onReject()
    {

    }

    public function onDelete()
    {

    }
}