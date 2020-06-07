<?php

class Learner_noveltiesController extends Controller{
    public function __construct() {
        parent::__construct();
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