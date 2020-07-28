<?php

class ReportsController extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }

        $this->view->scripts = [
            '/js/sweetalert.js',
            '/js/reports/main.js'
        ];

        $this->view->user = $_SESSION['user'];
        $this->learner_novelty = $this->loadModel('LearnerNovelty');
        $this->committee_session = $this->loadModel('CommitteeSession');
    }

    public function learner_novelties()
    {
        $learner_novelties = $this->learner_novelty->findByYear();
        $this->view->learner_novelties = $learner_novelties;
        $this->view->title = 'Reportes';
        $this->view->render('reports/learner_novelties');
    }
    public function stimuli_recommended()
    {
        $response = $this->committee_session->getRecommendedLearners();
        $this->view->learners = $response;
        $this->view->title = 'Reportes';
        $this->view->render('reports/stimuli_recommended');
    }

    public function render()
    {
        $this->view->title = 'Reportes';
        $this->view->render('reports/index');
    }
}