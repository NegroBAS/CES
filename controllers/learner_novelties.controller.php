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
        $this->learner_novelty = $this->loadModel('LearnerNovelty');
        $this->committee = $this->loadModel('Committee');
        $this->learner = $this->loadModel('Learner');
        $this->novelty_type = $this->loadModel('NoveltyType');
    }

    public function index()
    {
        $learner_novelties = $this->learner_novelty->all();
        $committees = $this->committee->all();
        $learners = $this->learner->all();
        $novelty_types = $this->novelty_type->all();
        echo json_encode([
            $learner_novelties,
            $committees,
            $learners,
            $novelty_types

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
        $res = $this->learner_novelty->create([
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
        $learner_novelty= $this->learner_novelty->find($id);
        echo json_encode($learner_novelty);
        
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
        $res = $this->learner_novelty->update([
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
        $res = $this->learner_novelty->delete($id);
        echo json_encode($res);
        
    }

    public function render()
    {
        $this->view->title = 'Novedades del aprendiz';
        $this->view->render('learner_novelties/index');
    }
}