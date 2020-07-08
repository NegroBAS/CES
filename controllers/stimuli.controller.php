<?php

class StimuliController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }
        $this->stimulus = $this->loadModel('Stimulus');
    }

    public function index($param = null)
    {
        $committee_id = $param[0];
        $data = $this->stimulus->all($committee_id);
        echo json_encode($data);
    }

    public function store()
    {
        $learner_id = $_POST['learner_id'];
        $committee_id = $_POST['committee_id'];
        $stimulus = $_POST['stimulus'];
        $justification = $_POST['justification'];
        $response = $this->stimulus->create([
            'learner_id'=>$learner_id,
            'committee_id' => $committee_id,
            'stimulus'=>$stimulus,
            'justification'=>$justification,
        ]);
        echo json_encode($response);
    }

    public function show($param = null)
    {
        $id = $param[0];
        $response = $this->stimulus->find($id);
        echo json_encode($response);
    }

    public function edit()
    {
    }

    public function destroy()
    {
    }
}
