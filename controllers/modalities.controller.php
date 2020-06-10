<?php

class ModalitiesController extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }

        $this->view->user = $_SESSION['user'];

        $this->view->scripts = [
            '/js/modalities/main.js',
            '/js/sweetalert.js'
        ];
        $this->modalities = $this->loadModel('Modality');
    }

    public function index()
    {
        $res = $this->modalities->all();
        echo json_encode(['modalities' => $res]);
        return;

    }

    public function store()
    {
        date_default_timezone_set("America/Bogota");
        $name = $_POST['name'];
        $created_at =date("Y,m,d,g,i,s");
        $updated_at=date("Y,m,d,g,i,s");
        $res = $this->modalities->create([
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
        $res= $this->modalities->find($id);
        echo json_encode($res);
        
    }

    public function edit($param = null)
    {
        date_default_timezone_set("America/Bogota");
        $id = $param[0];
        $name = $_POST['name'];
        $updated_at= date("Y,m,d,g,i,s");
        $res = $this->modalities->update([
            'id' => $id,
            'name' => $name,
            'updated_at' => $updated_at
        ]);
        echo json_encode($res);
        
    }

    public function destroy($param = null)
    {
        $id = $param[0];
        $res = $this->modalities->Delete($id);
        // $this->view->message = $res['message'];
       echo json_encode($res);
        
    }

    public function render()
    {
        $this->view->title = 'Modalidades';
        $this->view->render('modalities/index');
    }
}