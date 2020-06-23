<?php

class Formation_programsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location:' . constant('URL'));
        }

        $this->view->user = $_SESSION['user'];
        $this->view->scripts = [
            '/js/formation_programs/main.js',
            '/js/sweetalert.js'
        ];
        $this->formation_program = $this->loadModel('FormationProgram');
        $this->formation_program_type = $this->loadModel('FormationProgramType');
    }

    public function index()
    {
        $formation_programs = $this->formation_program->all();
        $formation_program_types = $this->formation_program_type->all();
        echo json_encode([
            $formation_programs,
            $formation_program_types
        ]);
        return;
    }

    public function store()
    {
        date_default_timezone_set("America/Bogota");
        $code = $_POST['code'];
        $name = $_POST['name'];
        $formation_program_type_id = $_POST['formation_program_type_id'];
        $created_at = date("Y,m,d,g,i,s");
        $updated_at = date("Y,m,d,g,i,s");
        $res = $this->formation_program->create([
            'code' => $code,
            'name' => $name,
            'formation_program_type_id' => $formation_program_type_id,
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ]);
        echo json_encode($res);
        return;
    }

    public function masive()
    {
        $formation_programs = json_decode($_POST['formation_programs']);
        $responses = [];
        foreach ($formation_programs as $formation_program) {
            $response = $this->formation_program->create([
                'id' => $formation_program->id,
                'code' => $formation_program->code,
                'name'=>$formation_program->name,
                'formation_program_type_id' => $formation_program->formationTypeId,
                'created_at' => date("Y,m,d,g,i,s"),
                'updated_at' => date("Y,m,d,g,i,s")
            ]);
            array_push($responses, $response);
        }
        echo json_encode([
            'status'=>200,
            'message'=>'Programas de formacion actualizados',
            'responses'=>$responses
        ]);
    }

    public function show($param = null)
    {
        $id = $param[0];
        $formation_program = $this->formation_program->find($id);
        echo json_encode($formation_program);
    }

    public function edit($param  = null)
    {
        date_default_timezone_set("America/Bogota");
        $id = $param[0];
        $code = $_POST['code'];
        $name = $_POST['name'];
        $formation_program_type_id = $_POST['formation_program_type_id'];
        $updated_at = date("Y,m,d,g,i,s");
        $res = $this->formation_program->update([
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
        $res = $this->formation_program->Delete($id);
        echo json_encode($res);
    }

    public function render()
    {
        $this->view->title = 'Programas de formación';
        $this->view->render('formation_programs/index');
    }
}
