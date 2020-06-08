<?php

class Not_foundController extends Controller
{
    public function __construct() {
        parent::__construct();
    }

    public function render()
    {
        $this->view->render('not_found/index');
    }
}