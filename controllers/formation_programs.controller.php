<?php

class Formation_programsController extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }

        $this->view->user = $_SESSION['user'];
        $this->view->scripts = [
            '/js/formation_programs/main.js',
        '/js/sweetalert.js'];
        $this->formation_programs = $this->loadModel('FormationProgram');
        $this->formation_program_types = $this->loadModel('FormationProgramType');
    }

    public function index()
    {
    $res1 = $this->formation_programs->all();
    $res2 = $this->formation_program_types->all();
    echo json_encode([
        'formation_programs' => $res1,
        'formation_program_types' => $res2
        ]);
    return;

    }

    public function store()
    {
        date_default_timezone_set("America/Bogota");
        $code = $_POST['code'];
        $name = $_POST['name'];
        $formation_program_type_id = $_POST['formation_program_type_id'];
        $created_at =date("Y,m,d,g,i,s");
        $updated_at=date("Y,m,d,g,i,s");
        $res = $this->formation_programs->create([
            'code' => $code,
            'name' => $name,
            'formation_program_type_id' => $formation_program_type_id,
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ]);
        echo json_encode($res);
        return;
        
    }

    public function show($param = null)
    {
        $id =$param[0];
        $res= $this->formation_programs->find($id);
        echo json_encode($res);
        
    }

    public function edit($param  = null)
    {
        date_default_timezone_set("America/Bogota");
        $id = $param[0];
        $code = $_POST['code'];
        $name = $_POST['name'];
        $formation_program_type_id = $_POST['formation_program_type_id'];
        $updated_at= date("Y,m,d,g,i,s");
        $res = $this->formation_programs->update([
            'id' => $id,
            'code' => $code,
            'name' => $name,
            'formation_program_type_id' => $formation_program_type_id,
            'updated_at' => $updated_at
        ]);
        echo json_encode($res);
        
    }

    public function destroy($param  = null)
    {
        $id = $param[0];
        $res = $this->formation_programs->Delete($id);
        echo json_encode($res);
        
    }

    public function render()
    {
        $this->view->title = 'Programas de formación';
        $this->view->render('formation_programs/index');
    }
}