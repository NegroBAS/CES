<?php
class SeederController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->committee_session_type = $this->loadModel('CommitteeSessionType');
        $this->committee_session_state = $this->loadModel('CommitteeSessionState');
        $this->formative_measure = $this->loadModel('FormativeMeasure');
        $this->infringement_classification = $this->loadModel('InfringementClassification');
        $this->infringement_type = $this->loadModel('InfringementType');
        $this->novelty_type = $this->loadModel('NoveltyType');
        $this->rol = $this->loadModel('Rol');
        $this->sanction = $this->loadModel('Sanction');
        $this->user = $this->loadModel('User');
    }

    public function seed_committee_session_types()
    {
        $data = [
            [
                'name' => 'Estímulos e incentivos'
            ],
            [
                'name' => 'Novedad del aprendiz'
            ],
            [
                'name' => 'Académico Disciplinario'
            ]
        ];
        $responses = [];
        for ($i = 0; $i < count($data); $i++) {
            $response = $this->committee_session_type->create($data[$i]);
            array_push($responses, $response);
        }
    }

    public function seed_formative_measures()
    {
        $data = [
            [
                'name' => 'Llamado de atención verbal'
            ],
            [
                'name' => 'Plan de mejoramiento disciplinario'
            ],
            [
                'name' => 'Plan de mejoramiento académico'
            ],
            [
                'name' => 'Plan de mejoramiento académico disciplinario'
            ]
        ];
        $responses = [];
        for ($i = 0; $i < count($data); $i++) {
            $response = $this->formative_measure->create($data[$i]);
            array_push($responses, $response);
        }
    }
    public function seed_infringement_classifications()
    {
        $data = [
            [
                'name' => 'Leve'
            ],
            [
                'name' => 'Grave'
            ],
            [
                'name' => 'Gravisima'
            ]
        ];
        $responses = [];
        for ($i = 0; $i < count($data); $i++) {
            $response = $this->infringement_classification->create($data[$i]);
            array_push($responses, $response);
        }
    }
    public function seed_infringement_types()
    {
        $data = [
            [
                'name' => 'Academica'
            ],
            [
                'name' => 'Disciplinaria'
            ]
        ];
        $responses = [];
        for ($i = 0; $i < count($data); $i++) {
            $response = $this->infringement_type->create($data[$i]);
            array_push($responses, $response);
        }
    }
    public function seed_novelty_types()
    {
        $data = [
            [
                'name' => 'Aplazamiento de matricula'
            ],
            [
                'name' => 'Retiro voluntario'
            ],
            [
                'name' => 'Traslado'
            ],
            [
                'name' => 'Reingreso'
            ],
            [
                'name' => 'Retiro Legalizado'
            ]
        ];
        $responses = [];
        for ($i = 0; $i < count($data); $i++) {
            $response = $this->novelty_type->create($data[$i]);
            array_push($responses, $response);
        }
    }

    public function seed_rols()
    {
        $data = [
            [
                'name' => 'Administrador'
            ],
            [
                'name' => 'Coordinador'
            ],
            [
                'name' => 'Subdirector'
            ]
        ];
        $responses = [];
        for ($i = 0; $i < count($data); $i++) {
            $response = $this->rol->create($data[$i]);
            array_push($responses, $response);
        }
    }

    public function seed_sanctions()
    {
        $data = [
            [
                'name' => 'Llamado de atención escrito'
            ],
            [
                'name' => 'Condicionamiento de matricula'
            ],
            [
                'name' => 'Cancelación de matricula'
            ]
        ];
        $responses = [];
        for ($i = 0; $i < count($data); $i++) {
            $response = $this->sanction->create($data[$i]);
            array_push($responses, $response);
        }
    }
    public function seed_users()
    {
        $data = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'rol_id' => 1,
                'password' => password_hash('admin2020', PASSWORD_DEFAULT, ['cost' => 10])
            ]
        ];
        $responses = [];
        for ($i = 0; $i < count($data); $i++) {
            $response = $this->user->create($data[$i]);
            array_push($responses, $response);
        }
    }

    public function seed_committee_session_states()
    {
        $data = [
            [
                'name'=>'Comunicación al aprendiz'
            ],
            [
                'name'=>'Acta de comité'
            ],
            [
                'name'=>'Acto sancionatorio'
            ]
        ];
        $responses = [];
        for ($i=0; $i < count($data); $i++) { 
            $response = $this->committee_session_state->create($data[$i]);
            array_push($responses,$response);
        }
    }

    public function seed_learners()
    {
        $data = [
            [
                'username'=>'Santiago Bedoya Arcila',
                'document_type_id'=>1,
                'document'=>2131231231,
                'phone'=>3123213212,
                'email'=>'santiago@email.com',
                'group_id'=>1
            ]
        ];
    }

    public function render()
    {
        $this->view->title = 'Seeder';
        $this->view->render('seeder/index');
        $this->seed_committee_session_types();
        $this->seed_committee_session_states();
        $this->seed_formative_measures();
        $this->seed_infringement_classifications();
        $this->seed_infringement_types();
        $this->seed_novelty_types();
        $this->seed_rols();
        $this->seed_sanctions();
        $this->seed_users();
        header('Location: ' . constant('URL'));
    }
}
