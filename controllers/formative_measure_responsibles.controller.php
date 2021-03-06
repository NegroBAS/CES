<?php

class Formative_measure_responsiblesController extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }
        $this->view->scripts = [
            '/js/formative_measure_responsibles/main.js',
            '/js/sweetalert.js'
        ];

        $this->view->user = $_SESSION['user'];
        $this->formative_measure_responsible = $this->loadModel('FormativeMeasureResponsible');
        $this->contract_type = $this->loadModel('ContractType');
        $this->position = $this->loadModel('Position');
    }

    public function index()
    {
        $formative_measure_responsibles = $this->formative_measure_responsible->all();
        // $contract_types = $this->contract_type->all();
        // $positions = $this->position->all();
        echo json_encode([
            $formative_measure_responsibles,
            // $contract_types,
            // $positions
        ]);
        return;
    }

    public function masive()
    {
        $data = $_POST['formative_measure_responsibles'];
        $data = json_decode($data);
        $responses = [];
        foreach ($data as $instructor) {
            $response = $this->formative_measure_responsible->create([
                'username' => $instructor->username,
                'misena_email' => $instructor->misena_email,
                'institutional_email'=>$instructor->institutional_email,
                'document_type' => 'CC',
                'document' => $instructor->document,
                'gender' => $instructor->gender,
                'birthdate' => date('Y-m-d H:i:s', strtotime($instructor->birthdate)),
                'phone' => $instructor->phone,
                'phone_ip' => $instructor->phone_ip,
                'position_id' => $instructor->positionId,
                'contract_type_id' => $instructor->contractTypeId,
                'state' => $instructor->state,
                'type'=>'Instructor'
            ]);
            array_push($responses, $response);
        }


        if(isset($response['error'])){
            $error = $response['error'];
            if($error[1] == "1452"){
                echo json_encode([
                        'status'=>500,
                        'message'=>'Actualizar tipo de contrato y/o cargos',
                        'responses'=>$responses
                    ]);
                }
            }else{
                echo json_encode([
                    'status'=>200,
                    'message'=>'Responsables actualizados',
                    'responses'=>$responses
            ]);
        }
        // echo json_encode($data);
    }

    public function store()
    {
        date_default_timezone_set("America/Bogota");
         $username = $_POST['username'];
          $misena_email = $_POST['misena_email'];
          $institutional_email = $_POST['institutional_email'];
          $document_type_id = $_POST['document_type_id'];
          $document = $_POST['document'];
          $birthdate = $_POST['birthdate'];
          $phone = $_POST['phone'];
          $phone_ip = $_POST['phone_ip'];
          $gender = $_POST['gender'];
          $position_id = $_POST['position_id'];
          $contract_type_id = $_POST['contract_type_id'];
          $type = $_POST['type'];
          $photo = "Vacio";//$_POST['photo'];
          $state = $_POST['state'];
          $res = $this->formative_measure_responsible->create([
            'username' => $username,
            'misena_email' => $misena_email,
            'institutional_email' => $institutional_email,
            'document_type_id' => $document_type_id,
            'document' => $document,
            'birthdate' => $birthdate,
            'phone' => $phone,
            'phone_ip' =>$phone_ip,
            'gender' => $gender,
            'position_id' => $position_id,
            'contract_type_id' => $contract_type_id,
            'type' => $type,
            'photo' => $photo,
            'state' => $state
          ]);
          echo json_encode($res);
          return;
        
    }

    public function show($param=null)
    {
        $id = $param[0];
        $res= $this->formative_measure_responsible->find($id);
        echo json_encode($res);
        
    }

    public function view($param = null){
        $id = $param[0];
        $formative_measure_responsible = $this->formative_measure_responsible->detail($id);
        echo json_encode($formative_measure_responsible);
    }

    public function edit($param = null)
    {
        date_default_timezone_set("America/Bogota");
        $id = $param[0];
         $username = $_POST['username'];
          $misena_email = $_POST['misena_email'];
          $institutional_email = $_POST['institutional_email'];
          $document_type_id = $_POST['document_type_id'];
          $document = $_POST['document'];
          $birthdate = $_POST['birthdate'];
          $phone = $_POST['phone'];
          $phone_ip = $_POST['phone_ip'];
          $gender = $_POST['gender'];
          $position_id = $_POST['position_id'];
          $contract_type_id = $_POST['contract_type_id'];
          $type = $_POST['type'];
          $photo = "Vacio";//$_POST['photo'];
          $state = $_POST['state'];
          $res = $this->formative_measure_responsible->update([
            'id'=>$id,
            'username' => $username,
            'misena_email' => $misena_email,
            'institutional_email' => $institutional_email,
            'document_type_id' => $document_type_id,
            'document' => $document,
            'birthdate' => $birthdate,
            'phone' => $phone,
            'phone_ip' =>$phone_ip,
            'gender' => $gender,
            'position_id' => $position_id,
            'contract_type_id' => $contract_type_id,
            'type' => $type,
            'photo' => $photo,
            'state' => $state
          ]);
          echo json_encode($res);
        
    }

    public function destroy($param = null)
    {
        $id = $param[0];
        $res = $this->formative_measure_responsible->delete($id);
        echo json_encode($res);
        
    }

    public function render()
    {
        $this->view->title = 'Responsables de medidas formativas';
        $this->view->render('formative_measure_responsibles/index');
    }
}