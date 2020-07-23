<?php

class Request 
{

    public $url;
    public $controller = "Controller";
    public $task = "index";
    public $params = [];

    public function __construct($url)
    {
        $this->url = $url;

    }
}