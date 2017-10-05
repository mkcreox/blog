<?php

namespace AppBundle\Controller\Rest;

use AppBundle\Entity\Post;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends FOSRestController
{
    /**
     * @Rest\Get("/rest/blog/list")
     */
    public function listAction()
    {
        $restresult = $this->getDoctrine()->getRepository(Post::class)->findAll();

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
        $restresult = $this->getDoctrine()->getRepository(Post::class)->find($id);

        if ($restresult === null) {
            return new View("user not found", Response::HTTP_NOT_FOUND);
        }

        $view = $this->view($restresult);
        return $this->handleView($view);
    }
}
