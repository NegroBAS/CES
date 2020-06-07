<?php

class RolsController extends Controller{
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
        $this->view->title = 'Roles';
        $this->view->render('rols/index');
    }
}