<?php

class CommitteesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location:' . constant('URL'));
        }
        $this->view->scripts = [
            '/js/committees/main.js'
        ];

        $this->view->user = $_SESSION['user'];
        $this->committee = $this->loadModel('Committee');
    }

    public function index()
    {
        $response = $this->committee->all();
        echo json_encode($response);
    }

    public function store()
    {
        $date = $_POST['date'];
        $start_hour = $_POST['start_hour'];
        $end_hour = $_POST['end_hour'];
        $record_number = $_POST['record_number'];
        $place = $_POST['place'];
        $formation_center = $_POST['formation_center'];
        $assistants = $_POST['assistants'];
        $qourum = $_POST['qourum'] == "on" ? 1 : 0;
        $subdirector_name = $_POST['subdirector_name'];
        $response = $this->committee->create([
            'date'=>$date,
            'start_hour'=>$start_hour,
            'end_hour'=>$end_hour,
            'record_number'=>$record_number,
            'place'=>$place,
            'formation_center'=>$formation_center,
            'assistants'=>$assistants,
            'qourum'=>$qourum,
            'subdirector_name'=>$subdirector_name
        ]);
        echo json_encode($response);
    }

    public function show($param = null)
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
        $this->view->title = 'Comites';
        $this->view->render('committees/index');
    }
}
