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
            $query = $this->db->connect()->prepare("SELECT committee_sessions.*, learners.username FROM committee_sessions INNER JOIN learners ON learners.id = committee_sessions.learner_id WHERE committee_sessions.committee_id = :id AND committee_sessions.committee_session_type_id = '1'");
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

    public function findStimulu($id)
    {
        try {
            $query = $this->db->connect()->prepare("SELECT committee_sessions.*, learners.username FROM committee_sessions INNER JOIN learners ON learners.id = committee_sessions.learner_id WHERE committee_sessions.id = :id AND committee_sessions.committee_session_type_id = '1'");
            $query->execute([
                'id'=>$id
            ]);
            while ($row = $query->fetch()) {
                $committee_session = new CommitteeSession();
                $committee_session->id = $row['id'];
                $committee_session->start_hour = $row['start_hour'];
                $committee_session->end_hour = $row['end_hour'];
                $committee_session->committee_session_type_id = $row['committee_session_type_id'];
                $committee_session->stimulus = $row['stimulus'];
                $committee_session->stimulus_justification = $row['stimulus_justification'];
                $committee_session->learner_id = $row['learner_id'];
                $committee_session->learner_name = $row['username'];
            }
            return [
                'status'=>200,
                'committee_session'=>$committee_session
            ];
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

    public function createAcademic($data)
    {
        try {
            $query = $this->db->connect()->prepare('INSERT INTO committee_sessions(start_hour, end_hour, committee_session_type_id, committee_id, learner_id) VALUES (:start_hour, :end_hour, :committee_session_type_id, :committee_id, :learner_id)');
            $query->execute([
                'start_hour'=>$data['start_hour'],
                'end_hour'=>$data['end_hour'],
                'committee_session_type_id'=>$data['committee_session_type_id'],
                'committee_id'=>$data['committee_id'],
                'learner_id'=>$data['learner_id']
            ]);
            return [
                'status'=>200,
                'message'=>'Nuevo caso creado'
            ];
        } catch (PDOException $e) {
            return [
                'status'=>500,
                'error'=>$e
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
