<?php

class Infringement_classificationsController extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }

        $this->view->user = $_SESSION['user'];
        $this->view->scripts = [
            '/js/infringement_classifications/main.js',
            '/js/sweetalert.js'
        ];
        $this->infringement_classification = $this->loadModel('InfringementClassification');
    }

    public function index()
    {
        $infringement_classifications = $this->infringement_classification->all();
        echo json_encode($infringement_classifications);
        return;

    }

    public function store()
    {
        date_default_timezone_set("America/Bogota");
        $name = $_POST['name'];
        $created_at =date("Y,m,d,g,i,s");
        $updated_at=date("Y,m,d,g,i,s");
        $res = $this->infringement_classification->create([
            'name' => $name,
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ]);
        echo json_encode($res);
        return;
        
    }

    public function show($param = null)
    {
        $id =$param[0];
        $infringement_classification= $this->infringement_classification->find($id);
        echo json_encode($infringement_classification);
        
    }

    public function edit($param = null)
    {
        date_default_timezone_set("America/Bogota");
        $id = $param[0];
        $name = $_POST['name'];
        $updated_at= date("Y,m,d,g,i,s");
        $res = $this->infringement_classification->update([
            'id' => $id,
            'name' => $name,
            'updated_at' => $updated_at
        ]);
        echo json_encode($res);
        
    }

    public function destroy($param = null)
    {
        $id = $param[0];
        $res = $this->infringement_classification->delete($id);
        echo json_encode($res);
        
    }

    public function render()
    {
        $this->view->title = 'Clasificacion de faltas';
        $this->view->render('infringement_classifications/index');
    }
}