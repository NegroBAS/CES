<?php

class LearnersController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location:' . constant('URL'));
        }

        $this->view->user = $_SESSION['user'];
        $this->view->scripts = [
            '/js/learners/main.js',
            '/js/sweetalert.js'
        ];
        $this->learner = $this->loadModel('Learner');
        $this->document_type = $this->loadModel('DocumentType');
        $this->group = $this->loadModel('Group');
    }

    public function index()
    {
        $leaners = $this->learner->all();
        echo json_encode([
            $leaners,
        ]);
    }

    public function store()
    {
        try {
            $username = $_POST['username'];
            $document_type = $_POST['document_type'];
            $document = $_POST['document'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $group_id = $_POST['group_id'];
            $birthdate = $_POST['birthdate'];
            if($_FILES['photo']['tmp_name']===""){
                $response = $this->learner->create([
                    'username' => $username,
                    'document_type' => $document_type,
                    'document' => $document,
                    'phone' => $phone,
                    'email' => $email,
                    'group_id' => $group_id,
                    'birthdate' => $birthdate,
                ]);
                echo json_encode($response);
            }else{
                if (getimagesize($_FILES['photo']['tmp_name'])) {
                    $path = "public/uploads/" . uniqid() . "." . strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
                    if ($_FILES['photo']['size'] <= 500000) {
                        $type = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
                        if ($type == 'jpg' || $type == 'jpeg' || $type == 'png') {
                            if (move_uploaded_file($_FILES['photo']['tmp_name'], $path)) {
                                $response = $this->learner->create([
                                    'username' => $username,
                                    'document_type' => $document_type,
                                    'document' => $document,
                                    'phone' => $phone,
                                    'email' => $email,
                                    'group_id' => $group_id,
                                    'birthdate' => $birthdate,
                                    'photo' => $path
                                ]);
                                echo json_encode($response);
                            }
                        } else {
                            echo json_encode([
                                'status' => 400,
                                'message' => 'La foto debe ser jpg/jpeg/png'
                            ]);
                        }
                    } else {
                        echo json_encode([
                            'status' => 400,
                            'message' => 'Este archivo es demasiado grande'
                        ]);
                    }
                } else {
                    echo json_encode([
                        'status' => 400,
                        'message' => 'Este archivo no es una imagen'
                    ]);
                }
            }
        } catch (PDOException $e) {
            echo json_encode([
                'error' => $e->getMessage()
            ]);
        }

    }

    public function show($param = null)
    {
        $id = $param[0];
        $res = $this->learner->find($id);
        echo json_encode($res);
    }

    public function edit($param = null)
    {

    }

    public function destroy($param = null)
    {
        $id = $param[0];
        $learner = $this->learner->find($id);
        if($learner['learner']->photo){
            unlink($learner['learner']->photo);
        }
        $res = $this->learner->Delete($id);
        echo json_encode($res);
    }

    public function render()
    {
        $this->view->title = 'Aprendices';
        $this->view->render('learners/index');
    }

    public function csv()
    {

        $data = array();
        $archivo = $_FILES['archivo']['tmp_name'];
        $group_id = $_POST['group_id_csv'];
        $readCsv = array_map('str_getcsv', file($archivo));


        //recorremos filas del csv
        foreach ($readCsv as $itemCsv) {
            //recorremos celdas del csv
            foreach ($itemCsv as $elementoItemCSV) {

                //guardando las filas
                $data[] = $elementoItemCSV;
            }
        }


        $count = count($data);

        for ($i=3; $i < $count ; $i++) { 
            $div = explode( ';', $data[$i] );

            $document_type = $div[0] == "CC" ? "CC" : "TI";
            $document = $div[1];
            $username = $div[2]." ".$div[3];
            $phone = $div[4];
            $email = $div[5];
            

            $res = $this->learner->create_csv([
                'username' => $username,
                'document_type' => $document_type,
                'document' => $document,
                'phone' => $phone,
                'email' => $email,
                'group_id' => $group_id

            ]);

        }

        echo json_encode($res);
    }
}
