<?php

class Contract_typesController extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }

        $this->view->user = $_SESSION['user'];

        $this->view->scripts = [
            '/js/contract_types/main.js',
            '/js/sweetalert.js'
        ];
        $this->contract = $this->loadModel('ContractType');

    }

    public function index()
    {

        $response = $this->contract->all();
        echo json_encode($response);
        return;


    }

    public function store()
    {
        $name = $_POST['name'];
        $res = $this->contract->create([
            'name' => $name
        ]);
        echo json_encode($res);
        return;        
    }

    public function show($param = null)
    {
        $id = $param[0];
        $res = $this->contract->find($id);
        echo json_encode([
            'contract_types' => $res,
            'status' => 200
            ]);
        
    }

    public function edit($param = null)
    {
        date_default_timezone_set("America/Bogota");
        $id = $param[0];
        $name = $_POST['name'];
        $res = $this->contract->update([
            'id' => $id,
            'name' => $name
        ]);
        echo json_encode($res);
        
    }

    public function destroy($param = null)
    {
        $id = $param[0];
        $res = $this->contract->Delete($id);
        echo json_encode($res);
        
    }

    public function masive()
    {
        $contract_types = json_decode($_POST['contract_types']);
        foreach ($contract_types as $contract_type) {
            $this->contract->create([
                'name'=>$contract_type->name
            ]);
        }
        echo json_encode([
            'status'=>200,
            'message'=>'Tipos de contratos actualizados'
        ]);
    }

    public function render()
    {
        $this->view->title = 'Tipos de contratos';
        $this->view->render('contract_types/index');
    }
}