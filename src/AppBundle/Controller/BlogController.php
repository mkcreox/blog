<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Post;
use AppBundle\Repository\PostRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\QueryBuilder;


class BlogController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction()
    {
        return $this->render('blog/homepage.twig',
            []
        );
    }
    /**
     * @Route("/{page}", name="list",requirements={"page": "\d+"})
     */
    public function indexAction($page = 1)
    {

        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM AppBundle:Post a ORDER BY a.date DESC";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate($query,$page,2);

        return $this->render('blog/list.twig',
            [
                'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
                "pagination"=>$pagination
            ]
        );
    }
    /**
     * @Route("/{slug}", name="detail")
     */
    public function showAction($slug){

        $post =  $this->getDoctrine()->getRepository(Post::class)->findOneBy(["url"=>$slug]);


        return $this->render('blog/show.twig',
            [
                "post"=>$post
            ]
        );
    }
}
