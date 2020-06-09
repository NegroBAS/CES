<?php

class PositionsController extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }

        $this->view->user = $_SESSION['user'];

        $this->view->scripts = [
            '/js/positions/main.js',
            '/js/sweetalert.js'
        ];
        $this->position = $this->loadModel('Position');

    }

    public function index()
    {
        $response = $this->position->all();
        echo json_encode($response);
        return;

    }

    public function store()
    {
        date_default_timezone_set("America/Bogota");
        if (isset($_POST['name']) & $_POST['name'] == "") {

            $error = "nombre vacio";
            $this->view->error = $error;
            $this->view->render('positions/create');
        } else {
            $name = $_POST['name'];
            $type = $_POST['type'];
            $created_at = date("Y,m,d,g,i,s");
            $updated_at = date("Y,m,d,g,i,s");
            $res = $this->position->store([
                'name' => $name,
                'type' => $type,
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ]);
            echo json_encode($res);
        }
        
    }

    public function show()
    {
        
    }

    public function edit($param  = null)
    {
        date_default_timezone_set("America/Bogota");
        $id = $param[0];
        $name = $_POST['name'];
        $type = $_POST['type'];
        $updated_at = date("Y,m,d,g,i,s");
        $res = $this->position->update([
            'id' => $id,
            'name' => $name,
            'type' => $type,
            'updated_at' => $updated_at
        ]);
        echo json_encode($res);
        
    }

    public function destroy($param  = null)
    {
        $id = $param[0];
        $res = $this->position->Delete($id);
        echo json_encode($res);
        
    }

    public function render()
    {
        $this->view->title = 'Cargos';
        $this->view->render('positions/index');
    }
}