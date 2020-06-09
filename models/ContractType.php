<?php

class ContractType extends Model{
    public $id;
    public $name;

    public function __construct() {
        parent::__construct();
    }

    public function all()
    {
        try {
            $contract_types = [];
            $query = $this->db->connect()->query('SELECT * FROM contract_types');
            while($row = $query->fetch()){
                $contract_type = new ContractType();
                $contract_type->id = $row['id'];
                $contract_type->name = $row['name'];
                array_push($contract_types, $contract_type);
            }
            return [
                'status'=>200,
                'contract_types'=>$contract_types
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
            $query = $this->db->connect()->prepare('INSERT INTO contract_types(name) VALUES (:name)');
            $query->execute([
                'name'=>$data['name']
            ]);
            return [
                'status'=>200,
                'message'=>'Nuevo tipo de contrato creado'
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