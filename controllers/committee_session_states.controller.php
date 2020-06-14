<?php

class Committee_session_statesController extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }

        $this->view->user = $_SESSION['user'];
        $this->view->scripts = [
            '/js/comitte_session_states/main.js',
            '/js/sweetalert.js'
        ];
        $this->comitte_session_states = $this->loadModel('CommitteeSessionState');
    }

    public function index()
    {
        $res = $this->comitte_session_states->all();
       echo json_encode(['comitte_session_states' => $res]);
       return;

    }

    public function store()
    {
        
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

    public function render()
    {
        $this->view->title = 'Estados de comite';
        $this->view->render('committee_session_states/index');
    }
}