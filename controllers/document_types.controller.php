<?php

class Document_typesController extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }

        $this->view->user = $_SESSION['user'];

        $this->view->scripts = [
            '/js/document_types/main.js',
            '/js/sweetalert.js'
        ];

        $this->document_type = $this->loadModel('DocumentType');

    }

    public function index()
    {
        $document_types = $this->document_type->all();
        echo json_encode($document_types);
        return;

    }

    public function store()
    {
        date_default_timezone_set("America/Bogota");

        $name = $_POST['name'];
        $created_at =date("Y,m,d,g,i,s");
        $updated_at=date("Y,m,d,g,i,s");
        $response = $this->document_type->create([
            'name' => $name,
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ]);
        echo json_encode($response);
        
    }

    public function show($param  = null)
    {
        $id = $param[0] ;
        $document_type = $this->document_type->find($id);
        echo json_encode($document_type);
        
    }

    public function edit($param  = null)
    {
        date_default_timezone_set("America/Bogota");
        $id = $param[0];
        $name = $_POST['name'];
        $updated_at= date("Y,m,d,g,i,s");
        $response = $this->document_type->update([
            'id' => $id,
            'name' => $name,
            'updated_at' => $updated_at
        ]);
        echo json_encode($response);
        
    }

    public function destroy($param  = null)
    {
        $id = $param[0];
        $response = $this->document_type->Delete($id);
        echo json_encode($response);
        
    }

    public function render()
    {
        $this->view->title = 'Tipos de documentos';
        $this->view->render('document_types/index');
    }
}