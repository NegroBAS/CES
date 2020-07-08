<?php

class Committee_sessionsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location:' . constant('URL'));
        }

        $this->view->user = $_SESSION['user'];
        $this->committee_session = $this->loadModel('CommitteeSession');
    }

    public function index($param = null)
    {
        $committee_id = $param[0];
        $response = $this->committee_session->all($committee_id);
        echo json_encode($response);
    }

    public function store()
    {
        $committee_id = $_POST['committee_id'];
        $start_hour = $_POST['start_hour'];
        $end_hour = $_POST['end_hour'];
        $learner_id = $_POST['learner_id'];
        $response = $this->committee_session->create([
            'committee_id'=>$committee_id,
            'start_hour'=>$start_hour,
            'end_hour'=>$end_hour,
            'learner_id'=>$learner_id
        ]);
        echo json_encode($response);
    }

    public function edit()
    {
    }

    public function destroy()
    {
    }
}
