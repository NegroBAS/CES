<?php

class SigninController extends Controller{
    public function __construct() {
        parent::__construct();
    }

    public function render()
    {
        $this->view->title = 'Iniciar Sesión';
        $this->view->render('signin/index');
    }
}