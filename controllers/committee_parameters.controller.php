<?php

class Committee_parametersController extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }

        $this->view->user = $_SESSION['user'];

        $this->view->scripts = [
            '/js/comitte_parameters/main.js',
            '/js/sweetalert.js'
        ];
        $this->comitte_parameter = $this->loadModel('CommitteeParameter');
        $this->comitte_session_state = $this->loadModel('CommitteeSessionState');
    }

    public function index()
    {
    $comitte_parameters = $this->comitte_parameter->all();
    $comitte_session_states = $this->comitte_session_state->all();
        echo json_encode([
            $comitte_parameters,
             $comitte_session_states
        ]);
    return;

    }

    public function store()
    {
        date_default_timezone_set("America/Bogota");
        $name = $_POST['name'];
        $content=$_POST['content'];
        $committee_session_state_id = $_POST['comitte_session_state_id'];
        $created_at =date("Y,m,d,g,i,s");
        $updated_at=date("Y,m,d,g,i,s");

        $res = $this->comitte_parameter->create([
            'name' => $name,
            'content' => $content,
            'committee_session_state_id'=> $committee_session_state_id,
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ]);
        echo json_encode($res);
        return;
        
    }

    public function show($param = null)
    {
        $id = $param[0];
        $comitte_parameter= $this->comitte_parameter->find($id);
        echo json_encode($comitte_parameter);
        
    }

    public function edit($param = null)
    {
        date_default_timezone_set("America/Bogota");
        $id = $param[0];
        $name = $_POST['name'];
        $content=$_POST['content'];
        $committee_session_state_id = $_POST['comitte_session_state_id'];
        $updated_at= date("Y,m,d,g,i,s");
        $res = $this->comitte_parameter->update([
                'id' => $id,
                'name' => $name,
                'content' => $content,
                'committee_session_state_id'=> $committee_session_state_id,
                'updated_at' => $updated_at
        ]);
        echo json_encode($res);
        
    }

    public function destroy($param = null)
    {
        $id = $param[0];
        $res = $this->comitte_parameter->delete($id);
        echo json_encode($res);
        
    }

    public function render()
    {
        $this->view->title = 'Parametros de comité';
        $this->view->render('committee_parameters/index');
    }
}