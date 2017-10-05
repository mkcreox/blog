<?php

namespace AppBundle\DTO\Rest;

class Post
{
    public $id;
    public $title;
    public $text;
    public $date;
    public $url;
    public $tags;

    public function __construct($id, $title, $text, $date, $url)
    {
        $this->id = $id;
        $this->title = $title;
        $this->date = $date;
        $this->text = $text;
        $this->url = $url;
        $this->tags = [];
    }
}