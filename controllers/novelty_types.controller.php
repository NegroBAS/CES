<?php

class Novelty_typesController extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }

        $this->view->scripts = [
            '/js/novelty_types/main.js'
        ];

        $this->view->user = $_SESSION['user'];
        $this->novelty_type = $this->loadModel('NoveltyType');
    }

    public function index()
    {
        $novelty_types = $this->novelty_type->all();
        echo json_encode($novelty_types);
    }

    public function store()
    {
        $name = $_POST['name'];
        $response = $this->novelty_type->create(['name'=>$name]);
        echo json_encode($response);
    }

    public function show($param = 0)
    {
        $id = $param[0];
        $novelty_type = $this->novelty_type->find($id);
        echo json_encode($novelty_type);
    }

    public function edit($param = null)
    {
        $id = $param[0];
        $name = $_POST['name'];
        $response = $this->novelty_type->update([
            'id'=>$id,
            'name'=>$name
        ]);
        echo json_encode($response);
    }

    public function destroy($param = null)
    {
        $id = $param[0];
        $response = $this->novelty_type->delete($id);
        echo json_encode($response);
    }

    public function render()
    {
        $this->view->title = 'Tipos de novedades';
        $this->view->render('novelty_types/index');
    }
}