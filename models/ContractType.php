<?php

class ContractType extends Model{

    public $id;
    public $name;
    public $created_at;
    public $updated_at;

    public function __construct() {
        parent::__construct();
    }

    public function all()
    {
        $contracts = [];
        try {
            $query = $this->db->connect()->query('SELECT * FROM contract_types');
            while ($row = $query->fetch()) {
                $contract = new ContractType();
                $contract->id = $row['id'];
                $contract->name = $row['name'];
                $contract->created_at = $row['created_at'];
                $contract->updated_at = $row['updated_at'];
                array_push($contracts, $contract);
            }
            return $contracts;

        } catch (PDOException $e) {
            return [
                'status'=>500,
                'error'=>$e
            ];
        }
    }

    public function masive($data)
    {
        try {
            $query = $this->db->connect()->prepare('INSERT INTO contract_types(created_at,id, name,updated_at) VALUES (:created_at,:id,:name,:updated_at) ');
            if ($query->execute([
                'created_at' => $data['createdAt'],
                'id'=>$data['id'],
                'name' => $data['name'],
                'updated_at' => $data['updatedAt']
            ])) {
                return [
                    'status' => 'ok',
                    'message' => 'Nuevo contrato Creado'
                ];
            }
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
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