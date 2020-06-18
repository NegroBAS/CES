<?php

class Database_errorController extends Controller
{
    public function __construct() {
        parent::__construct();
    }

    public function render()
    {
        $this->view->render('database_error/index');
    }
}