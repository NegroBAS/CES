<?php

class UsersController extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }

        $this->view->user = $_SESSION['user'];

        $this->view->scripts = [
            '/js/users/main.js',
            '/js/sweetalert.js'
        ];

        $this->user = $this->loadModel('User');
    }

    public function index()
    {
        $users = $this->user->all();
        echo json_encode($users);
    }

    public function store()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $rol_id = $_POST['rol_id'];
        $password = password_hash('12345678', PASSWORD_DEFAULT, ['cost'=>'10']);
        $response = $this->user->create([
            'name'=>$name,
            'email'=>$email,
            'rol_id'=>$rol_id,
            'password'=>$password
        ]);
        echo json_encode($response);
    }

    public function show($param = null)
    {
        $id = $param[0];
        $user = $this->user->find($id);
        echo json_encode($user);
    }

    public function findSubdirector()
    {
        $response = $this->user->findSubdirector();
        echo json_encode($response);
    }

    public function edit($param = null)
    {
        $id = $param[0];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $rol_id = $_POST['rol_id'];
        $response = $this->user->update([
            'name'=>$name,
            'email' => $email,
            'rol_id' => $rol_id,
            'id'=>$id
        ]);
        echo json_encode($response);
    }

    public function destroy($param = null)
    {
        $id = $param[0];
        $response = $this->user->delete($id);
        echo json_encode($response);
    }

    public function render()
    {
        $this->view->title = 'Usuarios';
        $this->view->render('users/index');
    }
}