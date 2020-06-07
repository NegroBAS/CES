<?php

class SanctionsController extends Controller{
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
        $this->view->title = 'Sanciones';
        $this->view->render('sanctions/index');
    }
}