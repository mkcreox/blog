<?php

namespace AppBundle\Repository;

use AppBundle\DTO\Rest\Post;
use AppBundle\DTO\Rest\Tag;

class PostRepository extends \Doctrine\ORM\EntityRepository
{
    public function getPostsForREST()
    {
        $query = $this->getEntityManager()->createQuery('SELECT NEW AppBundle\\DTO\\Rest\\SimplePost(p.id, p.title, p.date, p.url) FROM AppBundle\\Entity\\Post p');

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
            $post->getUrl());

        foreach ($post->getTags() as $tag) {
            $postDTO->tags[] = new Tag(
                $tag->getId(),
                $tag->getTitle()
            );
        }

        return $postDTO;
    }
}
