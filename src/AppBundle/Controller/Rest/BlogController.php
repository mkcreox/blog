<?php

namespace AppBundle\Controller\Rest;

use AppBundle\Entity\Post;
use AppBundle\Event\PostWasDisplayedEvent;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends FOSRestController
{
    /**
     * @Rest\Get("/rest/blog/list")
     */
    public function listAction()
    {
        $restresult = $this->getDoctrine()->getRepository(Post::class)->getPostsForREST();

        if ($restresult === null) {
            return new View("there are no users", Response::HTTP_NOT_FOUND);
        }

        $view = $this->view($restresult);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/rest/blog/show/{id}")
     */
    public function showAction($id)
    {
        $restresult = $this->getDoctrine()->getRepository(Post::class)->getPostForREST($id);

        if ($restresult === null) {
            return new View("user not found", Response::HTTP_NOT_FOUND);
        }

        $event = new PostWasDisplayedEvent($this->getDoctrine()->getRepository(Post::class)->find($id));
        $dispatcher = $this->get('event_dispatcher');
        $dispatcher->dispatch(PostWasDisplayedEvent::NAME, $event);

        $view = $this->view($restresult);
        return $this->handleView($view);
    }
}
