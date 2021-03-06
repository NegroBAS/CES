<?php

class SigninController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        session_start();
        if (isset($_SESSION['user'])) {
            header('Location:' . constant('URL') . 'dashboard');
        }

        $this->view->scripts = [
            '/js/signin/main.js'
        ];

        $this->user = $this->loadModel('User');
    }

    public function login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $response = $this->user->findByEmail($email);
        if ($response['user'] != null) {
            if (password_verify($password, $response['user']->password)) {
                $_SESSION['user'] = [
                    'name'=>$response['user']->name,
                    'email'=>$response['user']->email,
                    'rol_id'=>$response['user']->rol_id
                ];
                echo json_encode([
                    'status'=>200,
                    'message'=>'Logged'
                ]);
            }else{
                echo json_encode([
                    'status'=>401,
                    'message'=>'Invalid credentials'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 400,
                'message' => 'User not found'
            ]);
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: ' . constant('URL'));
    }

    public function render()
    {
        $this->view->title = 'Iniciar Sesión';
        $this->view->render('signin/index');
    }
}
