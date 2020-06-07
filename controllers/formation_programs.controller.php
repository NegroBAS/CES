<?php

class Formation_programsController extends Controller{
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
        $this->view->title = 'Programas de formación';
        $this->view->render('formation_programs/index');
    }
}