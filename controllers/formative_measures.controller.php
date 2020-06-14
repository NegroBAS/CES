<?php

class Formative_measuresController extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }

        $this->view->user = $_SESSION['user'];

        $this->view->scripts = [
            '/js/formative_measures/main.js',
            '/js/sweetalert.js'];
        $this->formative = $this->loadModel('FormativeMeasure');
    }

    public function index()
    {
        $res = $this->formative->all();
        echo json_encode(['formative_measures' => $res]);
        return;

    }

    public function store()
    {
        date_default_timezone_set("America/Bogota");
        $name = $_POST['name'];
        $created_at =date("Y,m,d,g,i,s");
        $updated_at=date("Y,m,d,g,i,s");
        $res = $this->formative->create([
            'name' => $name,
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ]);
        echo json_encode($res);
        return;
        
    }

    public function show($param = null)
    {
        $id = $param[0];
        $res= $this->formative->find($id);
        echo json_encode($res);
        
    }

    public function edit($param = null)
    {
        date_default_timezone_set("America/Bogota");
        $id = $param[0];
        $name = $_POST['name'];
        $updated_at= date("Y,m,d,g,i,s");
        $res = $this->formative->update([
            'id' => $id,
            'name' => $name,
            'updated_at' => $updated_at
        ]);
        echo json_encode($res);
        
    }

    public function destroy($param= null)
    {
        $id = $param[0];
        $res = $this->formative->delete($id);
        echo json_encode($res);
        
    }

    public function render()
    {
        $this->view->title = 'Medidas formativas';
        $this->view->render('formative_measures/index');
    }
}