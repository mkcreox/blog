<?php

namespace AppBundle\DTO\Rest;

class Post
{
    public $id;
    public $title;
    public $text;
    public $date;
    public $url;
    public $isActive;
    public $tags;
    public $views;

    public function __construct($id, $title, $text, $date, $url, $isActive, $views)
    {
        $this->id = $id;
        $this->title = $title;
        $this->date = $date;
        $this->text = $text;
        $this->url = $url;
        $this->isActive = $isActive;
        $this->views = $views;
        $this->tags = [];
    }
}