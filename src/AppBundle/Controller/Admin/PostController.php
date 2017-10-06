<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Post;
use AppBundle\Entity\Tag;
use AppBundle\Form\PostForm;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
            try {
                $em = $this->getDoctrine()->getManager();
                if (array_key_exists('tags', $request->request->get('post_form'))) {
                    foreach ($request->request->get('post_form')['tags'] as $tagId) {
                        $tag = $em->getRepository(Tag::class)->find($tagId);
                        $post->addTag($tag);
                        $tag->addPost($post);
                        $em->persist($tag);
                    }
                }
                $em->persist($post);
                $em->flush();

                $this->addFlash('notice', 'Post was created');
            } catch (UniqueConstraintViolationException $exception) {
                $this->addFlash('warning', 'Post was not created');
            }
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

        if (!$post) {
            $this->addFlash('warning', 'Post is not exist');
            return $this->redirectToRoute("admin_post");
        }

        $form = $this->createForm(PostForm::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                if (array_key_exists('tags', $request->request->get('post_form'))) {
                    foreach ($request->request->get('post_form')['tags'] as $tagId) {
                        $tag = $em->getRepository(Tag::class)->find($tagId);
                        $post->addTag($tag);
                        $tag->addPost($post);
                        $em->persist($tag);
                    }
                }
                $em->persist($post);
                $em->flush();
                $this->addFlash('notice', 'Post was updated');
            } catch (UniqueConstraintViolationException $exception) {
                $this->addFlash('warning', 'Post was not updated');
            }
            return $this->redirectToRoute("admin_post");
        }

        return $this->render('admin/post/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/post/setActive", name="admin_set_active")
     */
    public function setActiveAction(Request $request){
        try {
            $em = $this->getDoctrine()->getManager();
            $post = $em->getRepository(Post::class)->find($request->request->get("post_id"));
            $post->setIsActive($request->request->get("is_active"));
            $em->persist($post);
            $em->flush();

            $response = new Response(
                'Content',
                Response::HTTP_OK,
                array('content-type' => 'text/html')
            );

            return $response->send();
        } catch (UniqueConstraintViolationException $exception) {
            $response = new Response(
                'Content',
                Response::HTTP_BAD_REQUEST,
                array('content-type' => 'text/html')
            );

            return $response->send();
        }



    }
}
