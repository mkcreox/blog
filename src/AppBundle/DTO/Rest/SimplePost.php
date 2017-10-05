<?php

namespace AppBundle\DTO\Rest;

class SimplePost
{
    public $id;
    public $title;
    public $date;
    public $url;
    public $isActive;
    public $views;

    public function __construct($id, $title, $date, $url, $isActive, $views)
    {
        $this->id = $id;
        $this->title = $title;
        $this->date = $date;
        $this->url = $url;
        $this->isActive = $isActive;
        $this->views = $views;
    }
}