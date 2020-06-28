<?php

class CommitteeSession extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function allNovelties($committee_id)
    {
        try {
            $query = $this->db->connect()->prepare("SELECT * FROM committee_sessions INNER JOIN learners ON learners.id = committee_sessions.learner_id WHERE committee_sessions.committee_id = :id AND committee_sessions.committee_session_type_id = '2'");
            $query->execute([
                'id'=>$committee_id
            ]);
            $committee_sessions = [];
            while($row = $query->fetch()){
                $committee_session = new CommitteeSession();
                $committee_session->id = $row['id'];
                $committee_session->start_hour = $row['start_hour'];
                $committee_session->end_hour = $row['end_hour'];
                $committee_session->committee_session_type_id = $row['committee_session_type_id'];
                $committee_session->stimulus = $row['stimulus'];
                $committee_session->stimulus_justification = $row['stimulus_justification'];
                $committee_session->learner_id = $row['learner_id'];
                $committee_session->learner_name = $row['username'];
                array_push($committee_sessions, $committee_session);
            }
            return [
                'status'=>200,
                'committee_sessions_novelties'=>$committee_sessions
            ];
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
    }
    public function allAcademics($committee_id)
    {
        try {
            $query = $this->db->connect()->prepare("SELECT * FROM committee_sessions INNER JOIN learners ON learners.id = committee_sessions.learner_id WHERE committee_sessions.committee_id = :id AND committee_sessions.committee_session_type_id = '3'");
            $query->execute([
                'id'=>$committee_id
            ]);
            $committee_sessions = [];
            while($row = $query->fetch()){
                $committee_session = new CommitteeSession();
                $committee_session->id = $row['id'];
                $committee_session->start_hour = $row['start_hour'];
                $committee_session->end_hour = $row['end_hour'];
                $committee_session->committee_session_type_id = $row['committee_session_type_id'];
                $committee_session->stimulus = $row['stimulus'];
                $committee_session->stimulus_justification = $row['stimulus_justification'];
                $committee_session->learner_id = $row['learner_id'];
                $committee_session->learner_name = $row['username'];
                array_push($committee_sessions, $committee_session);
            }
            return [
                'status'=>200,
                'committee_sessions_academics'=>$committee_sessions
            ];
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
    }

    public function allStimulus($committee_id)
    {
        try {
            $query = $this->db->connect()->prepare("SELECT * FROM committee_sessions INNER JOIN learners ON learners.id = committee_sessions.learner_id WHERE committee_sessions.committee_id = :id AND committee_sessions.committee_session_type_id = '1'");
            $query->execute([
                'id'=>$committee_id
            ]);
            $committee_sessions = [];
            while($row = $query->fetch()){
                $committee_session = new CommitteeSession();
                $committee_session->id = $row['id'];
                $committee_session->start_hour = $row['start_hour'];
                $committee_session->end_hour = $row['end_hour'];
                $committee_session->committee_session_type_id = $row['committee_session_type_id'];
                $committee_session->stimulus = $row['stimulus'];
                $committee_session->stimulus_justification = $row['stimulus_justification'];
                $committee_session->learner_id = $row['learner_id'];
                $committee_session->learner_name = $row['username'];
                array_push($committee_sessions, $committee_session);
            }
            return [
                'status'=>200,
                'committee_sessions_stimulus'=>$committee_sessions
            ];
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'error' => $e
            ];
        }
    }

    public function find($id)
    {
        try {
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'error' => $e
            ];
        }
    }

    public function createStimulu($data)
    {
        try {
            $query = $this->db->connect()->prepare('INSERT INTO committee_sessions(start_hour, end_hour, committee_session_type_id, stimulus, stimulus_justification, committee_id, learner_id) VALUES (:start_hour, :end_hour, :committee_session_type_id, :stimulus, :stimulus_justification, :committee_id, :learner_id)');
            $query->execute([
                'start_hour'=>$data['start_hour'],
                'end_hour'=>$data['end_hour'],
                'committee_session_type_id'=>$data['committee_session_type_id'],
                'stimulus'=>$data['stimulus'],
                'stimulus_justification'=>$data['stimulus_justification'],
                'committee_id'=>$data['committee_id'],
                'learner_id'=>$data['learner_id']
            ]);
            return [
                'status'=>200,
                'message'=>'Nuevo caso agregado'
            ];
        } catch (PDOException $e) {
            return [
                'status'=>500,
                'error'=>$e
            ];
        }
    }

    public function createNovelty($data)
    {
        try {
            $query = $this->db->connect()->prepare('INSERT INTO committee_sessions(start_hour, end_hour, committee_session_type_id, novelty_type_id, committee_id, learner_id) VALUES (:start_hour, :end_hour, :committee_session_type_id, :stimulus, :stimulus_justification, :committee_id, :learner_id)');
            $query->execute([
                'start_hour'=>$data['start_hour'],
                'end_hour'=>$data['end_hour'],
                'committee_session_type_id'=>$data['committee_session_type_id'],
                'stimulus'=>$data['stimulus'],
                'stimulus_justification'=>$data['stimulus_justification'],
                'committee_id'=>$data['committee_id'],
                'learner_id'=>$data['learner_id']
            ]);
            return [
                'status'=>200,
                'message'=>'Nuevo caso agregado'
            ];
        } catch (PDOException $e) {
            return [
                'status'=>500,
                'error'=>$e
            ];
        }
    }

    public function create($data)
    {
        try {
            $query = $this->db->connect()->prepare("INSERT INTO `committee_sessions` (`place`, `start_hour`, `end_hour`, `committee_session_type_id`,`stimulus`,`stimulus_justification`, `complainer_id`, `committee_id`, `committee_session_state_id`, `date_academic_act_sanction`, `date_notification_act_sanction`, `date_expiration_act_sanction`, `date_lifting_act_sanction`, `sanction_justification`, `learner_id`, `infringement_type_id`, `infringemet_classification_id`, `notification_acts`, `notification_infringements`, `committee_a_case_treat`, `committee_a_type_discharge`, `committee_a_discharges`, `committee_a_clarification`, `committee_b_valuation_discharges`, `committee_b_existing_behavior`, `committee_b_behavior_type`, `committee_b_responsibility_grade`, `committee_b_infringement_classification`, `committee_b_determination_sanction_recomendation`, `act_sanction_acts_investigated`, `act_sanction_discharges`, `act_sanction_evidences`, `act_sanction_evidence_analysis`, `act_sanction_infringements`, `act_sanction_responsibility_grade`, `act_sanction_definitive_infringement_classification`, `act_sanction_infringement_type`, `act_sanction_reasons`, `act_sanction_notification`, `act_sanction_committee_recomendation`, `act_sanction_id`) VALUES (:place, :start_hour, :end_hour, :committee_session_type_id, :stimulus, :stimulus_justification, :complainer_id, :committee_id, :committee_session_state_id, :date_academic_act_sanction, :date_notification_act_sanction, :date_expiration_act_sanction, :date_lifting_act_sanction, :sanction_justification, :learner_id, :infringement_type_id, :infringemet_classification_id, :notification_acts, :notification_infringements, :committee_a_case_treat, :committee_a_type_discharge, :committee_a_discharges, :committee_a_clarification, :committee_b_valuation_discharges, :committee_b_existing_behavior, :committee_b_behavior_type, :committee_b_responsibility_grade, :committee_b_infringement_classification, :committee_b_determination_sanction_recomendation, :act_sanction_acts_investigated, :act_sanction_discharges, :act_sanction_evidences, :act_sanction_evidence_analysis, :act_sanction_infringements, :act_sanction_responsibility_grade, :act_sanction_definitive_infringement_classification, :act_sanction_infringement_type, :act_sanction_reasons, :act_sanction_notification, :act_sanction_committee_recomendation, :act_sanction_id);");
            $query->execute([
                'place' => $data['place'] ? $data['place'] : null,
                'start_hour' => $data['start_hour'] ? $data['start_hour'] : null,
                'end_hour' => $data['end_hour'] ? $data['end_hour'] : null,
                'committee_session_type_id' => $data['committee_session_type_id'] ? $data['committee_session_type_id'] : null,
                'stimulus' => $data['stimulus'] ? $data['stimulus'] : null,
                'stimulus_justification' => $data['stimulus_justification'] ? $data['stimulus_justification'] : null,
                'complainer_id' => $data['complainer_id'] ? $data['complainer_id'] : null,
                'committee_id' => $data['committee_id'] ? $data['committee_id'] : null,
                'committee_session_state_id' => $data['committee_session_state_id'] ? $data['committee_session_state_id'] : null,
                'date_academic_act_sanction' => $data['date_academic_act_sanction'] ? $data['date_academic_act_sanction'] : null,
                'date_notification_act_sanction' => $data['date_notification_act_sanction'] ? $data['date_notification_act_sanction'] : null,
                'date_expiration_act_sanction' => $data['date_expiration_act_sanction'] ? $data['date_expiration_act_sanction'] : null,
                'date_lifting_act_sanction' => $data['date_lifting_act_sanction'] ? $data['date_lifting_act_sanction'] : null,
                'sanction_justification' => $data['sanction_justification'] ? $data['sanction_justification'] : null,
                'learner_id' => $data['learner_id'] ? $data['learner_id'] : null,
                'infringement_type_id' => $data['infringement_type_id'] ? $data['infringement_type_id'] : null,
                'infringemet_classification_id' => $data['infringemet_classification_id'] ? $data['infringemet_classification_id'] : null,
                'notification_acts' => $data['notification_acts'] ? $data['notification_acts'] : null,
                'notification_infringements' => $data['notification_infringements'] ? $data['notification_infringements'] : null,
                'committee_a_case_treat' => $data['committee_a_case_treat'] ? $data['committee_a_case_treat'] : null,
                'committee_a_type_discharge' => $data['committee_a_type_discharge'] ? $data['committee_a_type_discharge'] : null,
                'committee_a_discharges' => $data['committee_a_discharges'] ? $data['committee_a_discharges'] : null,
                'committee_a_clarification' => $data['committee_a_clarification'] ? $data['committee_a_clarification'] : null,
                'committee_b_valuation_discharges' => $data['committee_b_valuation_discharges'] ? $data['committee_b_valuation_discharges'] : null,
                'committee_b_existing_behavior' => $data['committee_b_existing_behavior'] ? $data['committee_b_existing_behavior'] : null,
                'committee_b_behavior_type' => $data['committee_b_behavior_type'] ? $data['committee_b_behavior_type'] : null,
                'committee_b_responsibility_grade' => $data['committee_b_responsibility_grade'] ? $data['committee_b_responsibility_grade'] : null,
                'committee_b_infringement_classification' => $data['committee_b_infringement_classification'] ? $data['committee_b_infringement_classification'] : null,
                'committee_b_determination_sanction_recomendation' => $data['committee_b_determination_sanction_recomendation'] ? $data['committee_b_determination_sanction_recomendation'] : null,
                'act_sanction_acts_investigated' => $data['act_sanction_acts_investigated'] ? $data['act_sanction_acts_investigated'] : null,
                'act_sanction_discharges' => $data['act_sanction_discharges'] ? $data['act_sanction_discharges'] : null,
                'act_sanction_evidences' => $data['act_sanction_evidences'] ? $data['act_sanction_evidences'] : null,
                'act_sanction_evidence_analysis' => $data['act_sanction_evidence_analysis'] ? $data['act_sanction_evidence_analysis'] : null,
                'act_sanction_infringements' => $data['act_sanction_infringements'] ? $data['act_sanction_infringements'] : null,
                'act_sanction_responsibility_grade' => $data['act_sanction_responsibility_grade'] ? $data['act_sanction_responsibility_grade'] : null,
                'act_sanction_definitive_infringement_classification' => $data['act_sanction_definitive_infringement_classification'] ? $data['act_sanction_definitive_infringement_classification'] : null,
                'act_sanction_infringement_type' => $data['act_sanction_infringement_type'] ? $data['act_sanction_infringement_type'] : null,
                'act_sanction_reasons' => $data['act_sanction_reasons'] ? $data['act_sanction_reasons'] : null,
                'act_sanction_notification' => $data['act_sanction_notification'] ? $data['act_sanction_notification'] : null,
                'act_sanction_committee_recomendation' => $data['act_sanction_committee_recomendation'] ? $data['act_sanction_committee_recomendation'] : null,
                'act_sanction_id' => $data['act_sanction_id'] ? $data['act_sanction_id'] : null,
            ]);
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'error' => $e
            ];
        }
    }
    public function update($data)
    {
        try {
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'error' => $e
            ];
        }
    }

    public function delete($id)
    {
        try {
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'error' => $e
            ];
        }
    }
}
