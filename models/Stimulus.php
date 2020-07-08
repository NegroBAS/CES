<?php

class Stimulus extends Model{

    public function __construct() {
        parent::__construct();
    }

    public function all($committee_id)
    {
        try {
            $query = $this->db->connect()->prepare('SELECT * FROM stimuli INNER JOIN learners ON learners.id = stimuli.learner_id WHERE stimuli.committee_id = :id');
            $query->execute([
                'id'=>$committee_id
            ]);
            $stimuli = [];
            while($row = $query->fetch()){
                $stimulus = new Stimulus();
                $stimulus->id = $row['id'];
                $stimulus->learner_id = $row['learner_id'];
                $stimulus->learner_username = $row['username'];
                $stimulus->committee_id = $row['committee_id'];
                $stimulus->stimulus = $row['stimulus'];
                $stimulus->justification = $row['justification'];
                array_push($stimuli, $stimulus);
            }
            return [
                'status'=>200,
                'stimuli'=>$stimuli
            ];
        } catch (PDOException $e) {
            return [
                'status'=>500,
                'error'=>$e
            ];
        }
    }

    public function find($id)
    {
        try {
            $query = $this->db->connect()->prepare("SELECT * FROM stimuli INNER JOIN learners ON learners.id = stimuli.learner_id WHERE stimuli.id = :id");
            $query->execute([
                'id'=>$id
            ]);
            while($row = $query->fetch()){
                $stimulus = new Stimulus();
                $stimulus->id = $row['id'];
                $stimulus->learner_id = $row['learner_id'];
                $stimulus->learner_username = $row['username'];
                $stimulus->committee_id = $row['committee_id'];
                $stimulus->stimulus = $row['stimulus'];
                $stimulus->justification = $row['justification'];
            }
            return [
                'status'=>200,
                'stimulus'=>$stimulus
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
            $query = $this->db->connect()->prepare("INSERT INTO stimuli(learner_id, committee_id, stimulus, justification) VALUES (:learner_id, :committee_id, :stimulus, :justification)");
            $query->execute([
                'learner_id'=>$data['learner_id'],
                'committee_id'=>$data['committee_id'],
                'stimulus'=>$data['stimulus'],
                'justification'=>$data['justification']
            ]);
            return [
                'status'=>200,
                'message'=>'Estimulo agregado exitosamente'
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
                'status'=>500,
                'error'=>$e
            ];
        }
    }

    public function delete($id)
    {
        try {
            
        } catch (PDOException $e) {
            return [
                'status'=>500,
                'error' => $e
            ];
        }
    }
}