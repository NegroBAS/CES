<?php

class LearnersController extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }

        $this->view->user = $_SESSION['user'];
        $this->view->scripts = [
            '/js/sweetalert.js',
            '/js/learners/main.js'
        ];
        $this->learner = $this->loadModel('Learner');
        $this->document_types = $this->loadModel('DocumentType');
        $this->groups = $this->loadModel('Group');
    }

    public function index()
    {
        $response = $this->learner->all();
        $res1 = $this->document_types->all();
        $res2 = $this->groups->all();
        echo json_encode([
            'learners' => $response,
            'document_types' => $res1,
            'groups' => $res2,
            'status'=>200
        ]);
    }

    public function store()
    {
        date_default_timezone_set("America/Bogota");
     $username = $_POST['username'];
       $document_type_id = $_POST['document_type_id'];
       $document = $_POST['document'];
       $phone = $_POST['phone'];
       $email = $_POST['email'];
       $group_id = $_POST['group_id'];
       $birthdate = $_POST['birthdate'];
       $photo = "VACIO";//$_POST['photo'];
       $res = $this->learner->create([
           'username' => $username,
           'document_type_id' => $document_type_id,
           'document' => $document,
           'phone' => $phone,
           'email' => $email,
           'group_id' => $group_id,
           'birthdate' => $birthdate,
           'photo' => $photo
       ]);
       echo json_encode($res);
       return;
        
    }

    public function show($param = null)
    {
        $id = $param[0];
        $res= $this->learner->find($id);
        echo json_encode($res);
        
    }

    public function edit($param = null)
    {
    date_default_timezone_set("America/Bogota");
        $id = $param[0];
        $username = $_POST['username'];
        $document_type_id = $_POST['document_type_id'];
        $document = $_POST['document'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $group_id = $_POST['group_id'];
        $birthdate = $_POST['birthdate'];
        $updated_at=date("Y,m,d,g,i,s");
        $res = $this->learner->update([
            'id' => $id,
            'username' => $username,
            'document_type_id' => $document_type_id,
            'document' => $document,
            'phone' => $phone,
            'email' => $email,
            'group_id' => $group_id,
            'birthdate' => $birthdate,
            'updated_at' => $updated_at
        ]);
        echo json_encode($res);
        return;
        
    }

    public function destroy($param=null)
    {
        $id = $param[0];
        $res = $this->learner->Delete($id);
        echo json_encode($res);
        
    }

    public function render()
    {
        $this->view->title = 'Aprendices';
        $this->view->render('learners/index');
    }
}