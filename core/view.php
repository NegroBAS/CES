<?php

class View
{
    public $styles = [];
    public $scripts = [];
    function __construct()
    {
    }

    function render($nombre)
    {
        require 'views/' . $nombre . '.php';
    }
}
