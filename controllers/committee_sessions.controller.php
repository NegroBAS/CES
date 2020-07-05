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
        $this->learner_novelty = $this->loadModel('LearnerNovelty');
    }

    public function index($param = null)
    {
        $id = $param[0];
        $stimulus = $this->committee_session->allStimulus($id);
        $novelties = $this->learner_novelty->findByCommittee($id);
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

    public function storeAcademic()
    {
        $committee_id = $_POST['committee_id'];
        $start_hour = $_POST['start_hour'];
        $end_hour = $_POST['end_hour'];
        $learner_id = $_POST['learner_id'];
        $committee_session_type_id = $_POST['committee_session_type_id'];
        $response = $this->committee_session->createAcademic([
            'committee_id'=>$committee_id,
            'start_hour'=>$start_hour,
            'end_hour'=>$end_hour,
            'learner_id'=>$learner_id,
            'committee_session_type_id'=>$committee_session_type_id
        ]);
        echo json_encode($response);
        return;
    }

    public function showStimulu($param = null)
    {
        $id = $param[0];
        $committee_session = $this->committee_session->findStimulu($id);
        echo json_encode($committee_session);
    }

    public function edit()
    {
    }

    public function destroy()
    {
    }
}
