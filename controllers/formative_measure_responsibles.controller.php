<?php

class Formative_measure_responsiblesController extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }
        $this->view->scripts = [
            '/js/formative_measure_responsibles/main.js'
        ];

        $this->view->user = $_SESSION['user'];
        $this->formative_measure_responsible = $this->loadModel('FormativeMeasureResponsible');
    }

    public function index()
    {
        $response = $this->formative_measure_responsible->all();
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
        $this->view->title = 'Responsables de medidas formativas';
        $this->view->render('formative_measure_responsibles/index');
    }
}