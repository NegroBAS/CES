<?php

class Formation_program_typesController extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }

        $this->view->user = $_SESSION['user'];
        $this->view->scripts = [
            '/js/formation_program_types/main.js',
            '/js/sweetalert.js'
        ];
        $this->formation_program_type = $this->loadModel('FormationProgramType');
    }

    public function index()
    {
        $formation_program_types = $this->formation_program_type->all();
        echo json_encode($formation_program_types);
        return;


    }

    public function store()
    {
        date_default_timezone_set("America/Bogota");
        $name = $_POST['name'];
        $elective_months = $_POST['elective_months'];
        $practice_months = $_POST['practice_months'];
        $created_at =date("Y,m,d,g,i,s");
        $updated_at=date("Y,m,d,g,i,s");
        $res = $this->formation_program_type->create([
            'name' => $name,
            'elective_months' => $elective_months,
            'practice_months' => $practice_months,
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ]);
        echo json_encode($res);
        return;
        
    }

    public function show($param = null)
    {
        $id = $param[0];
        $formation_program_type= $this->formation_program_type->find($id);
        echo json_encode($formation_program_type);
        
    }

    public function edit($param = null)
    {
        date_default_timezone_set("America/Bogota");
        $id = $param[0];
        $name = $_POST['name'];
        $elective_months = $_POST['elective_months'];
        $practice_months = $_POST['practice_months'];
        $updated_at= date("Y,m,d,g,i,s");
        $res = $this->formation_program_type->update([
            'id' => $id,
            'name' => $name,
            'elective_months' => $elective_months,
            'practice_months' => $practice_months,
            'updated_at' => $updated_at
        ]);
        echo json_encode($res);
        
    }

    public function destroy($param = null)
    {
        $id = $param[0];
        $res = $this->formation_program_type->delete($id);
        echo json_encode($res);
        
    }

    public function render()
    {
        $this->view->title = 'Tipos de programas de formación';
        $this->view->render('formation_program_types/index');
    }
}