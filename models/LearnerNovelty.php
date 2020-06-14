<?php

class LearnerNovelty extends Model{

    public $id;
    public $learner_id;
    public $committee_id;
    public $novelty_type_id;
    public $justification;
    public $reply_date;
    public $created_at;
    public $updated_at;

    public function __construct() {
        parent::__construct();
    }

    public function all()
    {
        try {
            $requests = [];
            $query = $this->db->connect()->query('SELECT learner_novelties.id,learner_novelties.learner_id,
            learner_novelties.committee_id,learner_novelties.novelty_type_id,learner_novelties.justification,
            learner_novelties.reply_date,learner_novelties.created_at,learner_novelties.updated_at,learners.id as learners_id,
            learners.username as learners_name,committees.id as committees_id, committees.record_number as committees_number,
            novelty_types.id as novelty_id, novelty_types.name as novelty_name  FROM learner_novelties
            INNER JOIN learners ON learner_novelties.learner_id = learners.id 
            INNER JOIN committees ON learner_novelties.committee_id = committees.id  
            INNER JOIN novelty_types ON learner_novelties.novelty_type_id = novelty_types.id  ');
            while ($row = $query->fetch()) {
                $request = new LearnerNovelty();
                $request->id = $row['id'];
                $request->learner_id = $row['learner_id'];
                $request->committee_id = $row['committee_id'];
                $request->novelty_type_id = $row['novelty_type_id'];
                $request->justification = $row['justification'];
                $request->reply_date = $row['reply_date'];
                $request->created_at = $row['created_at'];
                $request->updated_at = $row['updated_at'];
                $request->learners_id = $row['learners_id'];
                $request->learners_name = $row['learners_name'];
                $request->committees_id = $row['committees_id'];
                $request->committees_number = $row['committees_number'];
                $request->novelty_id = $row['novelty_id'];
                $request->novelty_name = $row['novelty_name'];

                array_push($requests, $request);
            }
            return $requests;
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
            $request=[];
            $query = $this->db->connect()->prepare('SELECT * FROM learner_novelties WHERE id=:id');
            $query->bindParam('id',$id);
            $query->execute();

            while ($row = $query->fetch()) {
                $request = new LearnerNovelty();
                $request->id = $row['id'];
                $request->learner_id = $row['learner_id'];
                $request->committee_id = $row['committee_id'];
                $request->novelty_type_id = $row['novelty_type_id'];
                $request->justification = $row['justification'];
                $request->reply_date = $row['reply_date'];
                $request->created_at = $row['created_at'];
                $request->updated_at = $row['updated_at'];
                
            }
              
            return [
                'novelty'=>$request,
                'status'=>200

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
            $query = $this->db->connect()->prepare('INSERT INTO learner_novelties(learner_id,committee_id,novelty_type_id,justification,reply_date,created_at,updated_at) VALUES (:learner_id,:committee_id,:novelty_type_id,:justification,:reply_date,:created_at,:updated_at) ');
            if ($query->execute([
                'learner_id' => $data['learner_id'],
                'committee_id' => $data['committee_id'],
                'novelty_type_id' => $data['novelty_type_id'],
                'justification' => $data['justification'],
                'reply_date' => $data['reply_date'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at']
            ])){
                return [
                    'status' => 200,
                    'message' => 'Nueva novedad creada'
                ];
            } 
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
            $query = $this->db->connect()->prepare('UPDATE learner_novelties SET learner_id=:learner_id,committee_id=:committee_id,novelty_type_id=:novelty_type_id,justification=:justification,reply_date=:reply_date,updated_at=:updated_at WHERE id=:id ');
            if ($query->execute([
                'learner_id' => $data['learner_id'],
                'committee_id' => $data['committee_id'],
                'novelty_type_id' => $data['novelty_type_id'],
                'justification' => $data['justification'],
                'reply_date' => $data['reply_date'],
                'updated_at' => $data['updated_at'],
                'id' => $data['id']
                
            ])){
                return [
                    'status' => 200,
                    'message' => 'Solicitud actualizada'
                ];
            }             
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
            $query = $this->db->connect()->prepare('DELETE FROM learner_novelties  WHERE id=:id ');
            if ($query->execute([
                'id' =>$id
            ])){
                return [
                    'status' => 200,
                    'message' => 'Solicitud eliminada'
                ];
            } 
            
        } catch (PDOException $e) {
            return [
                'status'=>500,
                'error' => $e
            ];
        }
    }
}