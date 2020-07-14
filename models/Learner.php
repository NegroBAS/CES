<?php

class Learner extends Model{
    public $id;
    public $username;
    public $document_type_id;
    public $document;
    public $phone;
    public $email;
    public $group_id;
    public $birthdate;
    public $photo;

    public function __construct() {
        parent::__construct();
    }

    public function all()
    {
        $learners = [];
        try {
            $query = $this->db->connect()->query('SELECT * FROM learners');
            while($row = $query->fetch()){
                $learner = new Learner();
                $learner->id = $row['id'];
                $learner->username = $row['username'];
                $learner->document_type = $row['document_type'];
                $learner->document = $row['document'];
                $learner->phone = $row['phone'];
                $learner->email = $row['email'];
                $learner->group_id = $row['group_id'];
                $learner->birthdate = $row['group_id'];
                $learner->photo = $row['photo'];
                array_push($learners, $learner);
            }
            return [
                'status'=>200,
                'learners' => $learners
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
            $query = $this->db->connect()->prepare('SELECT * FROM learners WHERE id = :id');
            $query->execute([
                'id' => $id
            ]);
            while($row = $query->fetch()){
                $learner = new Learner();
                $learner->id = $row['id'];
                $learner->username = $row['username'];
                $learner->document_type_id = $row['document_type_id'];
                $learner->document = $row['document'];
                $learner->phone = $row['phone'];
                $learner->email = $row['email'];
                $learner->group_id = $row['group_id'];
                $learner->birthdate = $row['birthdate'];
                $learner->photo = $row['photo'];
            }
            return [
                'status' => 200,
                'learner' => $learner
            ];
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'error' => $e
            ];
        }
    }

    public function findview($id)
    {
        
    }

    public function create($data)
    {
        try {
            $query = $this->db->connect()->prepare('INSERT INTO learners(username, document_type, document, phone, email, group_id, birthdate, photo) VALUES (:username, :document_type, :document, :phone, :email, :group_id, :birthdate, :photo)');
            $query->execute([
                'username' => $data['username'],
                'document_type' => $data['document_type'],
                'document' => $data['document'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'group_id' => $data['group_id'],
                'birthdate' => $data['birthdate'],
                'photo' => $data['photo']
            ]);
            return [
                'status' => 200,
                'message' => 'Nuevo aprendiz agregado'
            ];
        } catch (PDOException $e) {
            return [
                'status'=>500,
                'error'=>$e
            ];
        }
    }

    public function create_csv($data)
    {
        try {
            $query = $this->db->connect()->prepare('INSERT INTO learners(username, document_type, document, phone, email, group_id) VALUES (:username, :document_type, :document, :phone, :email, :group_id)');
            $query->execute([
                'username' => $data['username'],
                'document_type' => $data['document_type'],
                'document' => $data['document'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'group_id' => $data['group_id']
            ]);
            return [
                'status' => 200,
                'message' => 'Aprendices agregados por CSV'
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
            $query = $this->db->connect()->prepare('UPDATE learners SET username = :username, document_type_id = :document_type_id, document = :document, phone = :phone, email = :email, group_id = :group_id, birthdate = :birthdate, photo = :photo WHERE id = :id');
            $query->execute([
                'username' => $data['username'],
                'document_type_id' => $data['document_type_id'],
                'document' => $data['document'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'group_id' => $data['group_id'],
                'birthdate' => $data['birthdate'],
                'photo' => $data['photo'],
                'id' => $data['id']
            ]);
            return [
                'status' => 200,
                'message' => 'Aprendiz actualizado'
            ];
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
            $query = $this->db->connect()->prepare('DELETE FROM learners WHERE id = :id');
            $query->execute([
                'id' => $id
            ]);
            return [
                'status'=>200,
                'message' => 'Aprendiz eliminado'
            ];
        } catch (PDOException $e) {
            return [
                'status'=>500,
                'error' => $e
            ];
        }
    }
}