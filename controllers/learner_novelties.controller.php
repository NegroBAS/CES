<?php

class Learner_noveltiesController extends Controller{
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

    public function store()
    {
        
    }

    public function show()
    {
        
    }

    public function edit()
    {
        
    }

    public function destroy()
    {
        
    }

    public function render()
    {
        $this->view->title = 'Novedades del aprendiz';
        $this->view->render('learner_novelties/index');
    }
}