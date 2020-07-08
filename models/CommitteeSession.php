<?php

class CommitteeSession extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function all($committee_id)
    {
        try {
            $query = $this->db->connect()->prepare("SELECT 
                committee_sessions.*, 
                learners.id AS learner_id, 
                learners.username AS 
                learner_username, 
                learners.document_type AS learner_document_type,
                learners.document AS learner_document,
                learners.phone AS learner_phone,
                learners.email AS learner_email,
                learners.group_id AS learner_group_id,
                learners.birthdate AS learner_birthdate,
                learners.photo AS learner_photo
                FROM committee_sessions 
                INNER JOIN learners ON learners.id = committee_sessions.learner_id 
                WHERE committee_sessions.committee_id = :id");
            $query->execute([
                'id' => $committee_id
            ]);
            $committee_sessions = [];
            while ($row = $query->fetch()) {
                $committee_session = new CommitteeSession();
                $committee_session->id = $row['id'];
                $committee_session->complainer_id = $row['complainer_id'];
                $committee_session->committee_id = $row['committee_id'];
                $committee_session->committee_session_type_id = $row['committee_session_type_id'];
                $committee_session->committee_session_state_id = $row['committee_session_state_id'];
                $committee_session->learner_id = $row['learner_id'];
                $committee_session->learner = [
                    'id'=>$row['learner_id'],
                    'username'=>$row['learner_username'],
                    'document_type'=>$row['learner_document_type'],
                    'document'=>$row['learner_document'],
                    'phone'=>$row['learner_phone'],
                    'email'=>$row['learner_email'],
                    'group_id'=>$row['learner_group_id'],
                    'birthdate'=>$row['learner_birthdate'],
                    'photo'=>$row['learner_photo']
                ];
                $committee_session->infringement_type_id = $row['infringement_type_id'];
                $committee_session->infringement_classification_id = $row['infringement_classification_id'];
                $committee_session->act_sanction_id = $row['act_sanction_id'];
                $committee_session->place = $row['place'];
                $committee_session->start_hour = $row['start_hour'];
                $committee_session->end_hour = $row['end_hour'];
                $committee_session->date_academic_act_sanction = $row['date_academic_act_sanction'];
                $committee_session->date_notification_act_sanction = $row['date_notification_act_sanction'];
                $committee_session->date_expiration_act_sanction = $row['date_expiration_act_sanction'];
                $committee_session->date_lifting_act_sanction = $row['date_lifting_act_sanction'];
                $committee_session->sanction_justification = $row['sanction_justification'];
                $committee_session->notification_acts = $row['notification_acts'];
                $committee_session->notification_infringements = $row['notification_infringements'];
                $committee_session->committee_a_case_treat = $row['committee_a_case_treat'];
                $committee_session->committee_a_type_discharge = $row['committee_a_type_discharge'];
                $committee_session->committee_a_discharges = $row['committee_a_discharges'];
                $committee_session->committee_a_clarification = $row['committee_a_clarification'];
                $committee_session->committee_b_valuation_discharges = $row['committee_b_valuation_discharges'];
                $committee_session->committee_b_existing_behavior = $row['committee_b_existing_behavior'];
                $committee_session->committee_b_behavior_type = $row['committee_b_behavior_type'];
                $committee_session->committee_b_responsibility_grade = $row['committee_b_responsibility_grade'];
                $committee_session->committee_b_infringement_classification = $row['committee_b_infringement_classification'];
                $committee_session->committee_b_determination_sanction_recomendation = $row['committee_b_determination_sanction_recomendation'];
                $committee_session->act_sanction_acts_investigated = $row['act_sanction_acts_investigated'];
                $committee_session->act_sanction_discharges = $row['act_sanction_discharges'];
                $committee_session->act_sanction_evidences = $row['act_sanction_evidences'];
                $committee_session->act_sanction_evidence_analysis = $row['act_sanction_evidence_analysis'];
                $committee_session->act_sanction_infringements = $row['act_sanction_infringements'];
                $committee_session->act_sanction_responsibility_grade = $row['act_sanction_responsibility_grade'];
                $committee_session->act_sanction_definitive_infringement_classification = $row['act_sanction_definitive_infringement_classification'];
                $committee_session->act_sanction_infringement_type = $row['act_sanction_infringement_type'];
                $committee_session->act_sanction_reasons = $row['act_sanction_reasons'];
                $committee_session->act_sanction_notification = $row['act_sanction_notification'];
                $committee_session->act_sanction_committee_recomendation = $row['act_sanction_committee_recomendation'];

                array_push($committee_sessions, $committee_session);
            }
            return [
                'status' => 200,
                'committee_sessions' => $committee_sessions
            ];
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'error' => $e
            ];
        }
    }

    public function create($data)
    {
        try {
            $query = $this->db->connect()->prepare("INSERT INTO committee_sessions(
                    complainer_id, 
                    committee_id, 
                    committee_session_type_id, 
                    committee_session_state_id, 
                    learner_id, 
                    infringement_type_id, 
                    infringement_classification_id, 
                    act_sanction_id, 
                    place, 
                    start_hour, 
                    end_hour, 
                    date_academic_act_sanction, 
                    date_notification_act_sanction, 
                    date_expiration_act_sanction, 
                    date_lifting_act_sanction, 
                    sanction_justification, 
                    notification_acts, 
                    notification_infringements, 
                    committee_a_case_treat, 
                    committee_a_type_discharge, 
                    committee_a_discharges, 
                    committee_a_clarification, 
                    committee_b_valuation_discharges, 
                    committee_b_existing_behavior,
                    committee_b_behavior_type,
                    committee_b_responsibility_grade,
                    committee_b_infringement_classification,
                    committee_b_determination_sanction_recomendation,
                    act_sanction_acts_investigated,
                    act_sanction_discharges,
                    act_sanction_evidences,
                    act_sanction_evidence_analysis,
                    act_sanction_infringements,
                    act_sanction_responsibility_grade,
                    act_sanction_definitive_infringement_classification,
                    act_sanction_infringement_type,
                    act_sanction_reasons,
                    act_sanction_notification,
                    act_sanction_committee_recomendation
                ) VALUES (
                    :complainer_id, 
                    :committee_id, 
                    :committee_session_type_id, 
                    :committee_session_state_id, 
                    :learner_id, 
                    :infringement_type_id, 
                    :infringement_classification_id, 
                    :act_sanction_id, 
                    :place, 
                    :start_hour, 
                    :end_hour, 
                    :date_academic_act_sanction, 
                    :date_notification_act_sanction, 
                    :date_expiration_act_sanction, 
                    :date_lifting_act_sanction, 
                    :sanction_justification, 
                    :notification_acts, 
                    :notification_infringements, 
                    :committee_a_case_treat, 
                    :committee_a_type_discharge, 
                    :committee_a_discharges, 
                    :committee_a_clarification, 
                    :committee_b_valuation_discharges, 
                    :committee_b_existing_behavior,
                    :committee_b_behavior_type,
                    :committee_b_responsibility_grade,
                    :committee_b_infringement_classification,
                    :committee_b_determination_sanction_recomendation,
                    :act_sanction_acts_investigated,
                    :act_sanction_discharges,
                    :act_sanction_evidences,
                    :act_sanction_evidence_analysis,
                    :act_sanction_infringements,
                    :act_sanction_responsibility_grade,
                    :act_sanction_definitive_infringement_classification,
                    :act_sanction_infringement_type,
                    :act_sanction_reasons,
                    :act_sanction_notification,
                    :act_sanction_committee_recomendation
                )");
            $query->execute([
                'complainer_id' => isset($data['complainer_id']) ? $data['complainer_id'] : null,
                'committee_id' => isset($data['committee_id']) ? $data['committee_id'] : null,
                'committee_session_type_id' => isset($data['committee_session_type_id']) ? $data['committee_session_type_id'] : null,
                'committee_session_state_id' => isset($data['committee_session_state_id']) ? $data['committee_session_state_id'] : 1,
                'learner_id' => isset($data['learner_id']) ? $data['learner_id'] : null,
                'infringement_type_id' => isset($data['infringement_type_id']) ? $data['infringement_type_id'] : null,
                'infringement_classification_id' => isset($data['infringement_classification_id']) ? $data['infringement_classification_id'] : null,
                'act_sanction_id' => isset($data['act_sanction_id']) ? $data['act_sanction_id'] : null,
                'place' => isset($data['place']) ? $data['place'] : null,
                'start_hour' => isset($data['start_hour']) ? $data['start_hour'] : null,
                'end_hour' => isset($data['end_hour']) ? $data['end_hour'] : null,
                'date_academic_act_sanction' => isset($data['date_academic_act_sanction']) ? $data['date_academic_act_sanction'] : null,
                'date_notification_act_sanction' => isset($data['date_notification_act_sanction']) ? $data['date_notification_act_sanction'] : null,
                'date_expiration_act_sanction' => isset($data['date_expiration_act_sanction']) ? $data['date_expiration_act_sanction'] : null,
                'date_lifting_act_sanction' => isset($data['date_lifting_act_sanction']) ? $data['date_lifting_act_sanction'] : null,
                'sanction_justification' => isset($data['sanction_justification']) ? $data['sanction_justification'] : null,
                'notification_acts' => isset($data['notification_acts']) ? $data['notification_acts'] : null,
                'notification_infringements' => isset($data['notification_infringements']) ? $data['notification_infringements'] : null,
                'committee_a_case_treat' => isset($data['committee_a_case_treat']) ? $data['committee_a_case_treat'] : null,
                'committee_a_type_discharge' => isset($data['committee_a_type_discharge']) ? $data['committee_a_type_discharge'] : null,
                'committee_a_discharges' => isset($data['committee_a_discharges']) ? $data['committee_a_discharges'] : null,
                'committee_a_clarification' => isset($data['committee_a_clarification']) ? $data['committee_a_clarification'] : null,
                'committee_b_valuation_discharges' => isset($data['committee_b_valuation_discharges']) ? $data['committee_b_valuation_discharges'] : null,
                'committee_b_existing_behavior' => isset($data['committee_b_existing_behavior']) ? $data['committee_b_existing_behavior'] : null,
                'committee_b_behavior_type' => isset($data['committee_b_behavior_type']) ? $data['committee_b_behavior_type'] : null,
                'committee_b_responsibility_grade' => isset($data['committee_b_responsibility_grade']) ? $data['committee_b_responsibility_grade'] : null,
                'committee_b_infringement_classification' => isset($data['committee_b_infringement_classification']) ? $data['committee_b_infringement_classification'] : null,
                'committee_b_determination_sanction_recomendation' => isset($data['committee_b_determination_sanction_recomendation']) ? $data['committee_b_determination_sanction_recomendation'] : null,
                'act_sanction_acts_investigated' => isset($data['act_sanction_acts_investigated']) ? $data['act_sanction_acts_investigated'] : null,
                'act_sanction_discharges' => isset($data['act_sanction_discharges']) ? $data['act_sanction_discharges'] : null,
                'act_sanction_evidences' => isset($data['act_sanction_evidences']) ? $data['act_sanction_evidences'] : null,
                'act_sanction_evidence_analysis' => isset($data['act_sanction_evidence_analysis']) ? $data['act_sanction_evidence_analysis'] : null,
                'act_sanction_infringements' => isset($data['act_sanction_infringements']) ? $data['act_sanction_infringements'] : null,
                'act_sanction_responsibility_grade' => isset($data['act_sanction_responsibility_grade']) ? $data['act_sanction_responsibility_grade'] : null,
                'act_sanction_definitive_infringement_classification' => isset($data['act_sanction_definitive_infringement_classification']) ? $data['act_sanction_definitive_infringement_classification'] : null,
                'act_sanction_infringement_type' => isset($data['act_sanction_infringement_type']) ? $data['act_sanction_infringement_type'] : null,
                'act_sanction_reasons' => isset($data['act_sanction_reasons']) ? $data['act_sanction_reasons'] : null,
                'act_sanction_notification' => isset($data['act_sanction_notification']) ? $data['act_sanction_notification'] : null,
                'act_sanction_committee_recomendation' => isset($data['act_sanction_committee_recomendation']) ? $data['act_sanction_committee_recomendation'] : null
            ]);
            return [
                'status' => 200,
                'message' => 'Caso academico/disciplinario agregado exitosamente'
            ];
        } catch (Throwable $e) {
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
