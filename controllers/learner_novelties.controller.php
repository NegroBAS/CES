<?php

class Learner_noveltiesController extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }

        $this->view->user = $_SESSION['user'];

        $this->view->scripts = [
            '/js/learner_novelties/main.js',
            '/js/sweetalert.js'
        ];
        $this->request = $this->loadModel('LearnerNovelty');
        $this->committees = $this->loadModel('Committee');
        $this->learners = $this->loadModel('Learner');
        $this->novelty_types = $this->loadModel('NoveltyType');
    }

    public function index()
    {
        $res = $this->request->all();
        $res1 = $this->committees->all();
        $res2 = $this->learners->all();
        $res3 = $this->novelty_types->all();
        echo json_encode([
            'learner_novelties' => $res,
            'committees' => $res1,
            'learners' => $res2,
            'novelty_types' => $res3
            ]);
        return;

    }

    public function store()
    {
        date_default_timezone_set("America/Bogota");
        $learner_id = $_POST['learner_id'];
        $committee_id = $_POST['committee_id'];
        $novelty_type_id = $_POST['novelty_type_id'];
        $justification = $_POST['justification'];
        $reply_date = $_POST['reply_date'];
        $created_at =date("Y,m,d,g,i,s");
        $updated_at=date("Y,m,d,g,i,s");
        $res = $this->request->create([
            'learner_id' => $learner_id,
            'committee_id' => $committee_id,
            'novelty_type_id' => $novelty_type_id,
            'justification' => $justification,
            'reply_date' => $reply_date,
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ]);
        echo json_encode($res);
        return;
        
    }

    public function show($param= null)
    {
        $id = $param[0];
        $res= $this->request->find($id);
        echo json_encode($res);
        
    }

    public function edit($param = null)
    {
        date_default_timezone_set("America/Bogota");
        $id = $param[0];
        $learner_id = $_POST['learner_id'];
        $committee_id = $_POST['committee_id'];
        $novelty_type_id = $_POST['novelty_type_id'];
        $justification = $_POST['justification'];
        $reply_date = $_POST['reply_date'];
        $updated_at= date("Y,m,d,g,i,s");
        $res = $this->request->update([
            'id' => $id,
            'learner_id' => $learner_id,
            'committee_id' => $committee_id,
            'novelty_type_id' => $novelty_type_id,
            'justification' => $justification,
            'reply_date' => $reply_date,
            'updated_at' => $updated_at
        ]);
        echo json_encode($res);
        
    }

    public function destroy($param = null)
    {
        $id = $param[0];
        $res = $this->request->delete($id);
        echo json_encode($res);
        
    }

    public function render()
    {
        $this->view->title = 'Novedades del aprendiz';
        $this->view->render('learner_novelties/index');
    }
}