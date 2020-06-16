<?php

class RolsController extends Controller{
    public function __construct() {
        parent::__construct();

        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }

        $this->view->user = $_SESSION['user'];

        $this->view->scripts = [
            '/js/rols/main.js',
            '/js/sweetalert.js'
        ];

        $this->rol = $this->loadModel('Rol');
    }

    public function index()
    {
        $rols = $this->rol->all();
        echo json_encode($rols);
        return;
    }

    public function store()
    {
        $name = $_POST['name'];
        $response = $this->rol->create([
            'name' => $name
        ]);
        echo json_encode($response);
        return;
    }

    public function show($param = null)
    {
        $id = $param[0];
        $rols = $this->rol->find($id);
        echo json_encode($rols);
    }

    public function edit($param = null)
    {
        $id = $param[0];
        $name = $_POST['name'];
        $response = $this->rol->update(['id'=>$id, 'name'=>$name]);
        echo json_encode($response);
    }

    public function destroy($param = null)
    {
        $id = $param[0];
        $response = $this->rol->delete($id);
        echo json_encode($response);
    }

    public function render()
    {
        $this->view->title = 'Roles';
        $this->view->render('rols/index');
    }
}