<?php

class DocumentType extends Model{

    public $id;
    public $name;
    public $created_at;
    public $updated_at;

    public function __construct() {
        parent::__construct();
    }

    public function all()
    {
        try {
            $types = [];
            $query = $this->db->connect()->query('SELECT * FROM document_types');
            while ($row = $query->fetch()) {
                $type = new DocumentType();
                $type->id = $row['id'];
                $type->name = $row['name'];
                $type->created_at = $row['created_at'];
                $type->updated_at = $row['updated_at'];
                array_push($types, $type);
            }
            return $types;

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
            $contract=[];
            $query = $this->db->connect()->prepare('SELECT * FROM document_types WHERE id=:id');
            $query->bindParam('id',$id);
            $query->execute();

            while ($row = $query->fetch()) {
                $contract = new DocumentType();
                $contract->id = $row['id'];
                $contract->name = $row['name'];
                $contract->created_at = $row['created_at'];
                $contract->updated_at = $row['updated_at'];
                
            }
              
            return $contract;

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
            $query = $this->db->connect()->prepare('INSERT INTO document_types(name,created_at,updated_at) VALUES (:name, :created_at, :updated_at) ');
            if ($query->execute([
                'name' => $data['name'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at']
            ])){
                return [
                    'status' => 'ok',
                    'message' => 'Nuevo contrato Creado'
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
            $query = $this->db->connect()->prepare('UPDATE document_types SET name=:name ,updated_at=:updated_at  WHERE id=:id ');
            if ($query->execute([
                'name' =>$data['name'],
                'updated_at' => $data['updated_at'],
                'id' => $data['id']
                
            ])){
                return [
                    'status' => 'ok',
                    'message' => 'Tipo Documento Actualizado '
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
            $query = $this->db->connect()->prepare('DELETE FROM document_types  WHERE id=:id ');
            if ($query->execute([
                'id' =>$id
            ])){
                return [
                    'status' => 'ok',
                    'message' => 'Tipo Documento Eliminado '
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