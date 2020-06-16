<?php

class DashboardController extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }

        $this->view->user = $_SESSION['user'];
    }

    public function index()
    {
    }

    public function render()
    {
        $this->view->title = 'Dashboard';
        $this->view->render('dashboard/index');
    }
}