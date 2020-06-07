<?php

class ErrorController extends Controller
{
    public function __construct() {
        parent::__construct();
    }

    public function render()
    {
        $this->view->render('error/index');
    }
}