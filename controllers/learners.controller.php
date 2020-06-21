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

        $url_photo = "public/photos/";
        $username = $_POST['username'];
        $document_type_id = $_POST['document_type_id'];
        $document = $_POST['document'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $group_id = $_POST['group_id'];
        $birthdate = $_POST['birthdate'];

       $photo = $url_photo. basename($_FILES["photo"]["name"]);
       $typeFile = strtolower(pathinfo($photo, PATHINFO_EXTENSION));
       $token = uniqid();


        if (isset($_FILES['photo'])) {
            if (is_uploaded_file($_FILES['photo']['tmp_name'])) {

                $rutaA1 = $_FILES['photo']['tmp_name'];

                    if($typeFile == "jpg" || $typeFile == "jpeg" || $typeFile == "png"){

                        if(is_uploaded_file($rutaA1)){
                            $destinoA1= $url_photo.$token.".".$typeFile;
                            $photo=$destinoA1;
                            copy($rutaA1,$destinoA1);
                        }else{
                            echo "debe selecionar una imagen 1";
                        }
    
    
                    }else{
                        echo "solo se admiten archivos jpg o jpeg";

                }
            } else {

                $destinoA1 = $photo;
            }
        }



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
        $document_type_id = $_POST['document_type_id'];
        $document = $_POST['document'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $group_id = $_POST['group_id'];
        $birthdate = $_POST['birthdate'];
        
       
            //si hay una nueva foto//
        if($_FILES['photo']['name']){

            $photo = $url_photo . basename($_FILES["photo"]["name"]);
            $typeFile = strtolower(pathinfo($photo, PATHINFO_EXTENSION));

     
            if(isset($_FILES['photo'])){

                 if (is_uploaded_file($_FILES['photo']['tmp_name'])) {   
     
                         $rutaA1=$_FILES['photo']['tmp_name'];
     
                         if($typeFile == "jpg" || $typeFile == "jpeg" || $typeFile == "png"){
     
     
                             if(is_uploaded_file($rutaA1)){
                                //  $destinoA1= $url_photo.$username."_".$document.".".$typeFile;
                                    $url_back = $_POST['photo_2'];
                                 $destinoA1= $url_back;
                                 $photo= $destinoA1;
                                 copy($rutaA1,$destinoA1);
                             }else{
                                 echo "debe selecionar una imagen 1";
                             }
         
         
                         }else{
                             echo "solo se admiten archivos jpg o jpeg";
                         }
                         
                         
                 
                 }else{
             
                     $destinoA1=$_POST['photo_2'];
                     
                 
                 }
             
             }
        }else{
            $photo = $_POST['photo_2'];
        }



        $res = $this->learner->update([
            'id' => $id,
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
}
