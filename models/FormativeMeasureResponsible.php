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