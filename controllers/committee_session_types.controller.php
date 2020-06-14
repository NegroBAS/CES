<?php

class Committee_session_typesController extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }

        $this->view->user = $_SESSION['user'];
        $this->view->scripts = [
            '/js/committee_session_types/main.js',
            '/js/sweetalert.js'
        ];
        $this->committee_session_type = $this->loadModel('CommitteeSessionType');
    }

    public function index()
    {
        $response = $this->committee_session_type->all();
        echo json_encode($response);
        return;
    }

    public function store()
    {
        $name = $_POST['name'];
        $res = $this->committee_session_type->create([
            'name' => $name,
            'created_at' => date("Y,m,d,g,i,s"),
            'updated_at' => date("Y,m,d,g,i,s")
        ]);
        echo json_encode($res);
        return;
        
    }

    public function show($param = null)
    {
        $id = $param[0];
        $res = $this->committee_session_type->find($id);
        echo json_encode($res);
        
    }

    public function edit($param = null)
    {
        $id = $param[0];
        $name = $_POST['name'];
        $res = $this->committee_session_type->update([
            'id' => $id,
            'name' => $name,
            'updated_at' => date("Y,m,d,g,i,s")
        ]);
        echo json_encode($res);
        
    }

    public function destroy($param = null)
    {
        $id = $param[0];
        $res = $this->committee_session_type->delete($id);
        echo json_encode($res);
        
    }

    public function render()
    {
        $this->view->title = 'Tipos de casos';
        $this->view->render('committee_session_types/index');
    }
}