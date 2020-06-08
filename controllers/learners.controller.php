<?php

class LearnersController extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }

        $this->view->user = $_SESSION['user'];
        $this->view->scripts = [
            '/js/learners/main.js'
        ];
        $this->learner = $this->loadModel('Learner');
    }

    public function index()
    {
        $response = $this->learner->all();
        echo json_encode($response);
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
        $this->view->title = 'Aprendices';
        $this->view->render('learners/index');
    }
}