<?php

namespace AppBundle\Repository;

use AppBundle\DTO\Rest\Post;
use AppBundle\DTO\Rest\Tag;

class PostRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * Move all dql queries to class
     */


    public function getPostsQuery()
    {
        return $this->getEntityManager()->createQuery('SELECT a FROM AppBundle:Post a WHERE a.isActive <> 0 ORDER BY a.date DESC');
    }

    public function getPostsForREST()
    {
        $query = $this->getEntityManager()->createQuery('SELECT NEW AppBundle\\DTO\\Rest\\SimplePost(p.id, p.title, p.date, p.url, p.isActive, p.views) FROM AppBundle\\Entity\\Post p');

        return $query->getResult();
    }

    public function getPostForREST(int $id)
    {
        $post = $this->find($id);

        if (!$post) {
            return null;
        }

        $postDTO = new Post(
            $post->getId(),
            $post->getTitle(),
            $post->getText(),
            $post->getDate(),
            $post->getUrl(),
            $post->getIsActive(),
            $post->getViews()
        );

        foreach ($post->getTags() as $tag) {
            $postDTO->tags[] = new Tag(
                $tag->getId(),
                $tag->getTitle()
            );
        }

        return $postDTO;
    }
}
