<?php

class PositionsController extends Controller{
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
        $this->view->title = 'Cargos';
        $this->view->render('positions/index');
    }
}