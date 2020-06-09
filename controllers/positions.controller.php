<?php

class PositionsController extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }

        $this->view->scripts = [
            '/js/positions/main.js'
        ];

        $this->view->user = $_SESSION['user'];
        $this->position = $this->loadModel('Position');
    }

    public function index()
    {
        $response = $this->position->all();
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

    public function masive()
    {
        $positions = json_decode($_POST['positions']);
        foreach ($positions as $position) {
            $response = $this->position->create([
                'name'=>$position->name,
                'type'=>$position->type
            ]);
        }
        echo json_encode([
            'status'=>200,
            'message'=>'Cargos actualizados'
        ]);
    }

    public function render()
    {
        $this->view->title = 'Cargos';
        $this->view->render('positions/index');
    }
}