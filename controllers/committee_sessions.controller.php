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
        $id = $param[0];
        $stimulus = $this->committee_session->allStimulus($id);
        $novelties = $this->committee_session->allNovelties($id);
        $academics = $this->committee_session->allAcademics($id);
        echo json_encode([
            'data'=>[
                $stimulus,
                $novelties,
                $academics
            ]
        ]);
    }

    public function storeStimulu()
    {
        $start_hour = $_POST['start_hour'];
        $end_hour = $_POST['end_hour'];
        $committee_id = $_POST['committee_id'];
        $committee_session_type_id = $_POST['committee_session_type_id'];
        $learner_id = $_POST['learner_id'];
        $stimulus = $_POST['stimulus'];
        $justification = $_POST['justification'];
        $response = $this->committee_session->createStimulu([
            'committee_id' => $committee_id,
            'committee_session_type_id' => $committee_session_type_id,
            'learner_id' => $learner_id,
            'stimulus' => $stimulus,
            'stimulus_justification' => $justification,
            'start_hour' => $start_hour,
            'end_hour'=>$end_hour
        ]);
        echo json_encode($response);
    }
    public function storeNovelty()
    {
        $start_hour = $_POST['start_hour'];
        $end_hour = $_POST['end_hour'];
        $committee_id = $_POST['committee_id'];
        $committee_session_type_id = $_POST['committee_session_type_id'];
        $learner_id = $_POST['learner_id'];
        $stimulus = $_POST['stimulus'];
        $justification = $_POST['justification'];
        $response = $this->committee_session->createStimulu([
            'committee_id' => $committee_id,
            'committee_session_type_id' => $committee_session_type_id,
            'learner_id' => $learner_id,
            'stimulus' => $stimulus,
            'stimulus_justification' => $justification,
            'start_hour' => $start_hour,
            'end_hour'=>$end_hour
        ]);
        echo json_encode($response);
    }

    public function show()
    {
    }

    public function edit()
    {
    }

    public function destroy()
    {
    }
}
