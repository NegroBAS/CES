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
        $document_types = $this->document_type->all();
        $groups = $this->group->all();
        echo json_encode([
            $leaners,
            $document_types,
            $groups
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
            $path = "public/uploads/" . uniqid() . "." . strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
            
            if (getimagesize($_FILES['photo']['tmp_name'])) {
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

        } catch (Throwable $e) {
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

    public function view($param = null)
    {
        $id = $param[0];
        $res = $this->learner->findview($id);
        echo json_encode($res);
    }

    public function edit($param = null)
    {
        $url_photo = "public/photos/";

        $id = $param[0];
        $username = $_POST['username'];
        $document_type = $_POST['document_type'];
        $document = $_POST['document'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $group_id = $_POST['group_id'];
        $birthdate = $_POST['birthdate'];


        //si hay una nueva foto//
        if ($_FILES['photo']['name']) {

            $photo = $url_photo . basename($_FILES["photo"]["name"]);
            $typeFile = strtolower(pathinfo($photo, PATHINFO_EXTENSION));


            if (isset($_FILES['photo'])) {

                if (is_uploaded_file($_FILES['photo']['tmp_name'])) {

                    $_SESSION["progreso"] = "cargando";

                    $rutaA1 = $_FILES['photo']['tmp_name'];
                    if ($typeFile == "jpg" || $typeFile == "jpeg" || $typeFile == "png") {
                        if (is_uploaded_file($rutaA1)) {
                            //  $destinoA1= $url_photo.$username."_".$document.".".$typeFile;
                            $url_back = $_POST['photo_2'];
                            $destinoA1 = $url_back;
                            $photo = $destinoA1;
                            copy($rutaA1, $destinoA1);
                            $progreso = "si";
                            $_SESSION["progreso"] = $progreso;
                        } else {
                            echo json_encode([
                                'status' => 400,
                                'message' => 'debe seleccionar una imagen'
                            ]);
                        }
                    } else {
                        echo json_encode([
                            'status' => 400,
                            'message' => 'La foto debe ser jpg/jpeg/png'
                        ]);
                    }
                } else {
                    $destinoA1 = $_POST['photo_2'];
                }
            }
        } else {
            $photo = $_POST['photo_2'];
        }



        // $res = $this->learner->update([
        //     'id' => $id,
        //     'username' => $username,
        //     'document_type' => $document_type,
        //     'document' => $document,
        //     'phone' => $phone,
        //     'email' => $email,
        //     'group_id' => $group_id,
        //     'birthdate' => $birthdate,
        //     'photo' => $photo
        // ]);
        echo json_encode([
            'id' => $id,
            'username' => $username,
            'document_type' => $document_type,
            'document' => $document,
            'phone' => $phone,
            'email' => $email,
            'group_id' => $group_id,
            'birthdate' => $birthdate,
            'photo' => $photo
        ]);
        return;
    }

    public function destroy($param = null)
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
