<?php

class Infringement_typesController extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }

        $this->view->user = $_SESSION['user'];

        $this->view->scripts = [
            '/js/infringement_types/main.js',
            '/js/sweetalert.js'
        ];
        $this->infringement_type = $this->loadModel('InfringementType');
    }

    public function index()
    {
        $infringement_types = $this->infringement_type->all();
       echo json_encode($infringement_types);
       return;

    }

    public function store()
    {
        date_default_timezone_set("America/Bogota");
        $name = $_POST['name'];
        $created_at =date("Y,m,d,g,i,s");
        $updated_at=date("Y,m,d,g,i,s");
        $res = $this->infringement_type->create([
            'name' => $name,
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ]);
        echo json_encode($res);
        return;
        
    }

    public function show($param = null)
    {
        $id = $param[0];
        $infringement_type= $this->infringement_type->find($id);
        echo json_encode($infringement_type);     
        
    }

    public function edit($param = null)
    {
        date_default_timezone_set("America/Bogota");
        $id = $param[0];
        $name = $_POST['name'];
        $updated_at= date("Y,m,d,g,i,s");
        $res = $this->infringement_type->update([
            'id' => $id,
            'name' => $name,
            'updated_at' => $updated_at
        ]);
        echo json_encode($res);
        
    }

    public function destroy($param = null)
    {
        $id = $param[0];
        $res = $this->infringement_type->delete($id);
        echo json_encode($res);
        
    }

    public function render()
    {
        $this->view->title = 'Tipos de faltas';
        $this->view->render('infringement_types/index');
    }
}