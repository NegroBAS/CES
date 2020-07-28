<?php

class ActController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location:' . constant('URL'));
        }
        $this->view->scripts = ['/js/act/main.js'];
        $this->view->user = $_SESSION['user'];

        $this->committee = $this->loadModel('Committee');
        $this->committee_session = $this->loadModel('CommitteeSession');
        $this->learner = $this->loadModel('Learner');
        $this->infringement_type = $this->loadModel('InfringementType');
        $this->infringement_classification = $this->loadModel('InfringementClassification');
    }

    public function committee($param = null)
    {
        $committee = $this->committee->find($param[0]);
        $this->view->committee = $committee;
        $this->view->title = 'Acta de comité';
        $this->view->render('act/index');
    }

    public function generate_communication()
    {
        $acts = $_POST['acts'];
        $infringements = $_POST['infringements'];
        $infringement_type_id = $_POST['infringement_type_id'];
        $infringement_classification_id = $_POST['infringement_classification_id'];
        $committee_id = $_POST['committee_id'];
        $learner_id = $_POST['learner_id'];

        $learner = $this->learner->find($learner_id);
        $committee = $this->committee->find($committee_id);

        $response = $this->committee_session->setCommunicationData([
            'acts'=>$acts,
            'infringements'=>$infringements,
            'id'=>$committee_id
        ]);
        // echo json_encode([
        //     'response'=>$response,
        //     'date'=>$committee->date,
        //     'place'=>$committee->formation_center,
        //     'hour'=>$committee->start_hour,
        //     'subdirector'=>$committee->subdirector_name
        // ]);

        \PhpOffice\PhpWord\Settings::setTempDir(getcwd() . '/public/templates');
        $template = new \PhpOffice\PhpWord\TemplateProcessor('public/templates/communication.docx');
        $template->setValue('learner_name', $learner['learner']->username);
        $template->setValue('learner_document', $learner['learner']->document_type." ".$learner['learner']->document);
        $template->setValue('learner_group', $learner['learner']->group['code_tab']);
        $template->setValue('learner_formation_program', $learner['learner']->group['formation_program']['name']);
        $template->setValue('formation_center', $committee->formation_center);
        $template->setValue('acts', $acts);
        $template->setValue('infringements', $infringements);
        $template->setValue('is_academic', $infringement_type_id==1?'___X___':'______');
        $template->setValue('is_disciplinary', $infringement_type_id==2?'___X___':'______');
        $template->setValue('is_leve', $infringement_classification_id==1?'___X___':'______');
        $template->setValue('is_grave', $infringement_classification_id==2?'___X___':'______');
        $template->setValue('is_gravisima', $infringement_classification_id==3?'___X___':'______');
        $template->setValue('committee_date', $committee->date);
        $template->setValue('committee_hour', $committee->start_hour);
        $template->setValue('committee_place', $committee->formation_center);
        $template->setValue('subdirector_name', $committee->subdirector_name);

        $template->saveAs('Communication.docx');

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename=Comunicacion-".$learner['learner']->username.".docx");
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Content-Length: ' . filesize('Communication.docx'));
        readfile('Communication.docx');
        unlink('Communication.docx');
    }
}
