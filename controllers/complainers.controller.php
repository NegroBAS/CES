<?php

class ComplainersController extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }
        $this->complainer = $this->loadModel('Complainer');
    }

    public function index()
    {
        $complainers = $this->complainer->all();
        echo json_encode($complainers);
    }

    public function store()
    {
        $name = $_POST['name'];
        $document_type_id = $_POST['document_type_id'];
        $document = $_POST['document'];
        $response = $this->complainer->create([
            'name'=>$name,
            'document_type_id'=>$document_type_id,
            'document'=>$document
        ]);
        echo json_encode($response);
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
}