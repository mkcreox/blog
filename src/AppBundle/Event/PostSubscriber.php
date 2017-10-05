<?php

namespace AppBundle\Event;


use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PostSubscriber implements EventSubscriberInterface
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return array(
            PostWasDisplayedEvent::NAME => 'onIncreaseView'
        );
    }

    public function onIncreaseView(PostWasDisplayedEvent $event)
    {

        $post = $event->getPost();

        $post->setViews($post->getViews() + 1);

        $this->em->persist($post);

        $this->em->flush();
    }

}