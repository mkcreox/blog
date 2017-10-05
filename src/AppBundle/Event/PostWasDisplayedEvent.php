<?php

namespace AppBundle\Event;

use AppBundle\Entity\Post;
use Symfony\Component\EventDispatcher\Event;

class PostWasDisplayedEvent extends Event
{
    const NAME = 'post.was.displayed';

    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function getPost()
    {
        return $this->post;
    }
}