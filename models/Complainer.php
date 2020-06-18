<?php

class Complainer extends Model{

    public function __construct() {
        parent::__construct();
    }

    public function all()
    {
        try {
            $complainers = [];
            $query = $this->db->connect()->query('SELECT * FROM complainers');
            while($row = $query->fetch()){
                $complainer = new Complainer();
                $complainer->id = $row['id'];
                $complainer->name = $row['name'];
                $complainer->document_type_id = $row['document_type_id'];
                $complainer->document = $row['document'];
                array_push($complainers, $complainer);
            }
            return [
                'status'=>200,
                'complainers'=>$complainers
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
            $query = $this->db->connect()->prepare('INSERT INTO complainers(name, document_type_id, document) VALUES (:name, :document_type_id, :document)');
            $query->execute([
                'name'=>$data['name'],
                'document_type_id'=>$data['document_type_id'],
                'document'=>$data['document']
            ]);
            return [
                'status'=>200,
                'message'=>'Complainer creado'
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