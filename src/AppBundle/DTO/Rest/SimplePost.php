<?php

namespace AppBundle\DTO\Rest;

class SimplePost
{
    public $id;
    public $title;
    public $date;
    public $url;

    public function __construct($id, $title, $date, $url)
    {
        $this->id = $id;
        $this->title = $title;
        $this->date = $date;
        $this->url = $url;
    }
}