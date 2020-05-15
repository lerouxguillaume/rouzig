<?php


namespace App\EventSuscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
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

    public static function getSubscribedEvents()
    {
        return [
            'workflow.' . self::NAME . '.transition.' . self::TRANSITION_UPDATE => 'onCreate',
            'workflow.' . self::NAME . '.transition.' . self::TRANSITION_UPDATE => 'onUpdate',
            'workflow.' . self::NAME . '.transition.' . self::TRANSITION_REVIEW => 'onReview',
            'workflow.' . self::NAME . '.transition.' . self::TRANSITION_ACCEPT => 'onAccept',
            'workflow.' . self::NAME . '.transition.' . self::TRANSITION_REJECT => 'onReject',
            'workflow.' . self::NAME . '.transition.' . self::TRANSITION_DELETE => 'onDelete',
        ];
    }

    public function onCreate(Event $event)
    {
        dump($event);die();
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