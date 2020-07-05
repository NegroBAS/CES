<?php

class ActController extends Controller 
{
    public function __construct() {
        parent::__construct();
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location:' . constant('URL'));
        }
        $this->view->scripts = ['/js/act/main.js'];
        $this->view->user = $_SESSION['user'];
        $this->committee = $this->loadModel('Committee');
    }

    public function committee($param = null)
    {
        $committee = $this->committee->find($param[0]);
        $this->view->committee = $committee;
        $this->view->title = 'Acta de comité';
        $this->view->render('act/index');
    }
}
