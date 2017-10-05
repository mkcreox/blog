<?php

namespace AppBundle\Controller\Rest;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

class BlogController extends FOSRestController
{
    /**
     * @Rest\Get("/rest/blog/list")
     */
    public function listAction(Request $request)
    {
        $restresult = $this->getDoctrine()->getRepository(Post::class)->findAll();

        if ($restresult === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }

        return $restresult;
    }
}
