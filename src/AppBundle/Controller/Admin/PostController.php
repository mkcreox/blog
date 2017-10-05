<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Post;
use AppBundle\Entity\Tag;
use AppBundle\Form\PostForm;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller
{
    /**
     * @Route("/admin/post", name="admin_post")
     */
    public function indexAction()
    {
        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findAll();

        return $this->render('admin/post/index.html.twig', [
            "posts" => $posts
        ]);
    }

    /**
     * @Route("/admin/post/add", name="admin_post_add")
     */
    public function addAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(PostForm::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
//            foreach ($request->request->get('post_form')['tags'] as $tagId) {
//                $tag = $em->getRepository('AppBundle:Tag')->find($tagId);
//                $post->addTag($tag);
//                $em->persist($tag);
//                $em->persist($post);
//                $em->flush();
//            }

            $tag = $em->getRepository(Tag::class)->find(1);
            $post->addTag($tag);
            $em->persist($tag);
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute("admin_post");
        }

        return $this->render('admin/post/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/post/edit/{id}", name="admin_post_edit", requirements={"id": "\d+"})
     */
    public function editAction($id = 1, Request $request)
    {
        $post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->find($id);

        $form = $this->createForm(PostForm::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($post);
                $em->flush();
            } catch (UniqueConstraintViolationException $exception) {

            }
            return $this->redirectToRoute("admin_post");
        }

        return $this->render('admin/post/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/post/setActive", name="admin_post_set_active")
     */
    public function setActiveAction($idPost)
    {
        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findAll();

        return $this->render('admin/post/index.html.twig', [
            "posts" => $posts
        ]);
    }
}
