<?php

class FormativeMeasureResponsible extends Model{
    public $id;
    public $username;
    public $misena_email;
    public $institutional_email;
    public $document_type_id;
    public $document;
    public $birthdate;
    public $phone;
    public $phone_ip;
    public $gender;
    public $position_id;
    public $contract_type_id;
    public $type;
    public $photo;
    public $state;

    public function __construct() {
        parent::__construct();
    }

    public function all()
    {
        try {
            $formative_measure_responsibles = [];
            $query = $this->db->connect()->query('SELECT * FROM formative_measure_responsibles');
            while ($row = $query->fetch()) {
                $formative_measure_responsible = new FormativeMeasureResponsible();
                $formative_measure_responsible->id = $row['id'];
                $formative_measure_responsible->username = $row['username'];
                $formative_measure_responsible->misena_email = $row['misena_email'];
                $formative_measure_responsible->institutional_email = $row['institutional_email'];
                $formative_measure_responsible->document_type = $row['document_type'];
                $formative_measure_responsible->document = $row['document'];
                $formative_measure_responsible->birthdate = $row['birthdate'];
                $formative_measure_responsible->phone = $row['phone'];
                $formative_measure_responsible->phone_ip = $row['phone_ip'];
                $formative_measure_responsible->gender = $row['gender'];
                $formative_measure_responsible->position_id = $row['position_id'];
                $formative_measure_responsible->contract_type_id = $row['contract_type_id'];
                $formative_measure_responsible->type = $row['type'];
                $formative_measure_responsible->photo = $row['photo'];
                $formative_measure_responsible->state = $row['state'];
                array_push($formative_measure_responsibles, $formative_measure_responsible);
            }
            return [
                'status'=>200,
                'formative_measure_responsibles' => $formative_measure_responsibles
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
            $query = $this->db->connect()->prepare('SELECT * FROM formative_measure_responsibles WHERE id = :id');
            $query->execute([
                'id' => $id
            ]);
            while($row = $query->fetch()){
                $formative_measure_responsible = new FormativeMeasureResponsible();
                $formative_measure_responsible->id = $row['id'];
                $formative_measure_responsible->username = $row['username'];
                $formative_measure_responsible->misena_email = $row['misena_email'];
                $formative_measure_responsible->institutional_email = $row['institutional_email'];
                $formative_measure_responsible->document_type_id = $row['document_type_id'];
                $formative_measure_responsible->document = $row['document'];
                $formative_measure_responsible->birthdate = $row['birthdate'];
                $formative_measure_responsible->phone = $row['phone'];
                $formative_measure_responsible->phone_ip = $row['phone_ip'];
                $formative_measure_responsible->gender = $row['gender'];
                $formative_measure_responsible->position_id = $row['position_id'];
                $formative_measure_responsible->contract_type_id = $row['contract_type_id'];
                $formative_measure_responsible->type = $row['type'];
                $formative_measure_responsible->photo = $row['photo'];
                $formative_measure_responsible->state = $row['state'];
            }
            return [
                'status' => 200,
                'formative_measure_responsible' => $formative_measure_responsible
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
            $query = $this->db->connect()->prepare('INSERT INTO formative_measure_responsibles(username, misena_email, institutional_email, document_type, document, birthdate,phone, phone_ip, gender, position_id,contract_type_id,type,state) VALUES (:username, :misena_email, :institutional_email, :document_type, :document, :birthdate,:phone, :phone_ip, :gender, :position_id, :contract_type_id, :type, :state)');
            $query->execute([
                'username' => $data['username'],
                'misena_email' => $data['misena_email'],
                'institutional_email' => $data['institutional_email'],
                'document_type' => $data['document_type'],
                'document' => $data['document'],
                'birthdate' => $data['birthdate'],
                'phone' => $data['phone'],
                'phone_ip' => $data['phone_ip'],
                'gender' => $data['gender'],
                'position_id' => $data['position_id'],
                'contract_type_id' => $data['contract_type_id'],
                'type' => $data['type'],
                'state' => $data['state']
            ]);
            return [
                'status' => 200,
                'message' => 'Nuevo responsable agregado'
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
            $query = $this->db->connect()->prepare('UPDATE formative_measure_responsibles SET username = :username, misena_email = :misena_email, institutional_email = :institutional_email, document_type_id = :document_type_id, document = :document, birthdate = :birthdate, phone = :phone, phone_ip = :phone_ip, gender = :gender, position_id = :position_id, contract_type_id = :contract_type_id, type = :type, photo = :photo, state = :state WHERE id = :id');
            $query->execute([
                'username' => $data['username'],
                'misena_email' => $data['misena_email'],
                'institutional_email' => $data['institutional_email'],
                'document_type_id' => $data['document_type_id'],
                'document' => $data['document'],
                'birthdate' => $data['birthdate'],
                'phone' => $data['phone'],
                'phone_ip' => $data['phone_ip'],
                'gender' => $data['gender'],
                'position_id' => $data['position_id'],
                'contract_type_id' => $data['contract_type_id'],
                'type' => $data['type'],
                'photo' => $data['photo'],
                'state' => $data['state'],
                'id' => $data['id']
            ]);
            return [
                'status' => 200,
                'message' => 'Responsable actualizado'
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
            $query = $this->db->connect()->prepare('DELETE FROM formative_measure_responsibles WHERE id = :id');
            $query->execute([
                'id' => $id
            ]);
            return [
                'status'=>200,
                'message' => 'Responsable eliminado'
            ];
            
        } catch (PDOException $e) {
            return [
                'status'=>500,
                'error' => $e
            ];
        }
    }
}