<?php

class Controller
{
    public $view;
    function __construct()
    {
        date_default_timezone_set("America/Bogota");
        $this->view = new View();
    }

    function loadModel($model)
    {
        $url = 'models/' . $model . '.php';
        if (file_exists($url)) {
            require $url;
            return new $model;
        }
    }
}
