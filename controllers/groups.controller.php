<?php

class GroupsController extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }

        $this->view->user = $_SESSION['user'];

        $this->view->scripts = [
            '/js/groups/main.js'
        ];
        $this->groups = $this->loadModel('Group');
        $this->modalities = $this->loadModel('Modality');
        $this->formation_programs = $this->loadModel('FormationProgram');
    }

    public function index()
    {
        $res = $this->groups->all();
       $res1 = $this->modalities->all();
       $res2 = $this->formation_programs->all();
       echo json_encode([
           'groups' => $res,
           'modalities' => $res1,
           'formation_programs' => $res2
           ]);
        return;

    }

    public function store()
    {
        date_default_timezone_set("America/Bogota");

        $code_tab = $_POST['code_tab'];
        $modality_id = $_POST['modality_id'];
        $formation_program_id = $_POST['formation_program_id'];
        $quantity_learners = $_POST['quantity_learners'];
        $active_learners = $_POST['active_learners'];
        $elective_start_date = $_POST['elective_start_date'];
        $elective_end_date = $_POST['elective_end_date'];
        $practice_start_date = $_POST['practice_start_date'];
        $practice_end_date = $_POST['practice_end_date'];
        $created_at =date("Y,m,d,g,i,s");
        $updated_at=date("Y,m,d,g,i,s");
        $res = $this->groups->store([
            'code_tab' => $code_tab,
            'modality_id' => $modality_id,
            'formation_program_id' => $formation_program_id,
            'quantity_learners' => $quantity_learners,
            'active_learners' => $active_learners,
            'elective_start_date' => $elective_start_date,
            'elective_end_date' => $elective_end_date,
            'practice_start_date' => $practice_start_date,
            'practice_end_date' => $practice_end_date,
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ]);


        echo json_encode($res);
        return;
        
    }

    public function show($param = null)
    {
        $id = $param[0];
        $res= $this->groups->find($id);
        echo json_encode($res);
        
    }

    public function edit($param = null)
    {
        date_default_timezone_set("America/Bogota");
        $id = $param[0];
        $code_tab = $_POST['code_tab'];
        $modality_id = $_POST['modality_id'];
        $formation_program_id = $_POST['formation_program_id'];
        $quantity_learners = $_POST['quantity_learners'];
        $active_learners = $_POST['active_learners'];
        $elective_start_date = $_POST['elective_start_date'];
        $elective_end_date = $_POST['elective_end_date'];
        $practice_start_date = $_POST['practice_start_date'];
        $practice_end_date = $_POST['practice_end_date'];
        $updated_at= date("Y,m,d,g,i,s");
        $res = $this->groups->update([
            'id' => $id,
            'code_tab' => $code_tab,
            'modality_id' => $modality_id,
            'formation_program_id' => $formation_program_id,
            'quantity_learners' => $quantity_learners,
            'active_learners' => $active_learners,
            'elective_start_date' => $elective_start_date,
            'elective_end_date' => $elective_end_date,
            'practice_start_date' => $practice_start_date,
            'practice_end_date' => $practice_end_date,
            'updated_at' => $updated_at
        ]);

       echo json_encode($res);
        
    }

    public function destroy($param = null)
    {
        $id = $param[0];
        $res = $this->groups->Delete($id);
        echo json_encode($res);
        
    }

    public function render()
    {
        $this->view->title = 'Grupos';
        $this->view->render('groups/index');
    }
}