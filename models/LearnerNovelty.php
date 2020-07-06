<?php

class LearnerNovelty extends Model
{

    public $id;
    public $learner_id;
    public $committee_id;
    public $novelty_type_id;
    public $justification;
    public $reply_date;
    public $created_at;
    public $updated_at;

    public function __construct()
    {
        parent::__construct();
    }

    public function findByLearner($id)
    {
        try {
            $query = $this->db->connect()->prepare('SELECT learner_novelties.*, novelty_types.name AS novelty_type FROM learner_novelties INNER JOIN novelty_types ON learner_novelties.novelty_type_id = novelty_types.id WHERE learner_id = :id');
            $query->execute([
                'id'=>$id
            ]);
            $learner_novelties = [];
            while($row = $query->fetch()){
                $learner_novelty = new LearnerNovelty();
                $learner_novelty->id = $row['id'];
                $learner_novelty->learner_id = $row['learner_id'];
                $learner_novelty->committee_id = $row['committee_id'];
                $learner_novelty->justification = $row['justification'];
                $learner_novelty->reply_date = $row['reply_date'];
                $learner_novelty->novelty_type = $row['novelty_type'];
                $learner_novelty->novelty_type_id = $row['novelty_type_id'];
                array_push($learner_novelties, $learner_novelty);
            }
            return [
                'status'=>200,
                'learner_novelties'=>$learner_novelties
            ];
        } catch (PDOException $e) {
            return [
                'status'=>500,
                'error'=>$e
            ];
        }
    }

    public function all()
    {
        try {
            $learner_novelties = [];
            $query = $this->db->connect()->query('SELECT learner_novelties.id,learner_novelties.learner_id,
            learner_novelties.committee_id,learner_novelties.novelty_type_id,learner_novelties.justification,
            learner_novelties.reply_date,learner_novelties.created_at,learner_novelties.updated_at,learners.id as learners_id,
            learners.username as learners_name,committees.id as committees_id, committees.record_number as committees_number,
            novelty_types.id as novelty_id, novelty_types.name as novelty_name  FROM learner_novelties
            INNER JOIN learners ON learner_novelties.learner_id = learners.id 
            INNER JOIN committees ON learner_novelties.committee_id = committees.id  
            INNER JOIN novelty_types ON learner_novelties.novelty_type_id = novelty_types.id');
            while ($row = $query->fetch()) {
                $learner_novelty = new LearnerNovelty();
                $learner_novelty->id = $row['id'];
                $learner_novelty->learner_id = $row['learner_id'];
                $learner_novelty->committee_id = $row['committee_id'];
                $learner_novelty->novelty_type_id = $row['novelty_type_id'];
                $learner_novelty->justification = $row['justification'];
                $learner_novelty->reply_date = $row['reply_date'];
                $learner_novelty->created_at = $row['created_at'];
                $learner_novelty->updated_at = $row['updated_at'];
                $learner_novelty->learners_id = $row['learners_id'];
                $learner_novelty->learners_name = $row['learners_name'];
                $learner_novelty->committees_id = $row['committees_id'];
                $learner_novelty->committees_number = $row['committees_number'];
                $learner_novelty->novelty_id = $row['novelty_id'];
                $learner_novelty->novelty_name = $row['novelty_name'];

                array_push($learner_novelties, $learner_novelty);
            }
            return [
                'learner_novelties' => $learner_novelties,
                'status' => 200
            ];
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'error' => $e
            ];
        }
    }

    public function findByCommittee($id)
    {
        try {
            $query = $this->db->connect()->prepare('SELECT learner_novelties.id,learner_novelties.learner_id,
            learner_novelties.committee_id,learner_novelties.novelty_type_id,learner_novelties.justification,
            learner_novelties.reply_date,learner_novelties.created_at,learner_novelties.updated_at,learners.id as learners_id,
            learners.username as learners_name,committees.id as committees_id, committees.record_number as committees_number,
            novelty_types.id as novelty_id, novelty_types.name as novelty_name  FROM learner_novelties
            INNER JOIN learners ON learner_novelties.learner_id = learners.id 
            INNER JOIN committees ON learner_novelties.committee_id = committees.id  
            INNER JOIN novelty_types ON learner_novelties.novelty_type_id = novelty_types.id WHERE learner_novelties.committee_id = :id');
            $query->execute([
                'id' => $id
            ]);
            $learner_novelties = [];
            while ($row = $query->fetch()) {
                $learner_novelty = new LearnerNovelty();
                $learner_novelty->id = $row['id'];
                $learner_novelty->learner_id = $row['learner_id'];
                $learner_novelty->committee_id = $row['committee_id'];
                $learner_novelty->novelty_type_id = $row['novelty_type_id'];
                $learner_novelty->justification = $row['justification'];
                $learner_novelty->reply_date = $row['reply_date'];
                $learner_novelty->created_at = $row['created_at'];
                $learner_novelty->updated_at = $row['updated_at'];
                $learner_novelty->learners_id = $row['learners_id'];
                $learner_novelty->learners_name = $row['learners_name'];
                $learner_novelty->committees_id = $row['committees_id'];
                $learner_novelty->committees_number = $row['committees_number'];
                $learner_novelty->novelty_id = $row['novelty_id'];
                $learner_novelty->novelty_name = $row['novelty_name'];
                array_push($learner_novelties, $learner_novelty);
            }
            return [
                'status' => 200,
                'learner_novelties' => $learner_novelties
            ];
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
    }

    public function find($id)
    {
        try {
            $learner_novelty = [];
            $query = $this->db->connect()->prepare('SELECT learner_novelties.*, learners.username AS learner_username, novelty_types.name AS novelty_type_name FROM learner_novelties INNER JOIN learners ON learners.id = learner_novelties.learner_id INNER JOIN novelty_types ON novelty_types.id =  learner_novelties.novelty_type_id WHERE learner_novelties.id= :id');
            $query->bindParam('id', $id);
            $query->execute();

            while ($row = $query->fetch()) {
                $learner_novelty = new LearnerNovelty();
                $learner_novelty->id = $row['id'];
                $learner_novelty->learner_id = $row['learner_id'];
                $learner_novelty->learner_username = $row['learner_username'];
                $learner_novelty->committee_id = $row['committee_id'];
                $learner_novelty->novelty_type_id = $row['novelty_type_id'];
                $learner_novelty->novelty_type_name = $row['novelty_type_name'];
                $learner_novelty->justification = $row['justification'];
                $learner_novelty->reply_date = $row['reply_date'];
                $learner_novelty->created_at = $row['created_at'];
                $learner_novelty->updated_at = $row['updated_at'];
            }
            return [
                'learner_novelty' => $learner_novelty,
                'status' => 200

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
            $query = $this->db->connect()->prepare('INSERT INTO learner_novelties(learner_id,committee_id,novelty_type_id,justification,created_at,updated_at) VALUES (:learner_id,:committee_id,:novelty_type_id,:justification,:created_at,:updated_at) ');
            if ($query->execute([
                'learner_id' => $data['learner_id'],
                'committee_id' => $data['committee_id'],
                'novelty_type_id' => $data['novelty_type_id'],
                'justification' => $data['justification'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at']
            ])) {
                return [
                    'status' => 200,
                    'message' => 'Nueva novedad creada'
                ];
            }
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
            $query = $this->db->connect()->prepare('UPDATE learner_novelties SET learner_id=:learner_id,committee_id=:committee_id,novelty_type_id=:novelty_type_id,justification=:justification,reply_date=:reply_date,updated_at=:updated_at WHERE id=:id ');
            if ($query->execute([
                'learner_id' => $data['learner_id'],
                'committee_id' => $data['committee_id'],
                'novelty_type_id' => $data['novelty_type_id'],
                'justification' => $data['justification'],
                'reply_date' => $data['reply_date'],
                'updated_at' => $data['updated_at'],
                'id' => $data['id']

            ])) {
                return [
                    'status' => 200,
                    'message' => 'Solicitud actualizada'
                ];
            }
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
            $query = $this->db->connect()->prepare('DELETE FROM learner_novelties  WHERE id=:id ');
            if ($query->execute([
                'id' => $id
            ])) {
                return [
                    'status' => 200,
                    'message' => 'Solicitud eliminada'
                ];
            }
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'error' => $e
            ];
        }
    }
}
