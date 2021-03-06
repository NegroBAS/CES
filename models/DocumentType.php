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
            $document_types = [];
            $query = $this->db->connect()->query('SELECT * FROM document_types');
            while ($row = $query->fetch()) {
                $document_type = new DocumentType();
                $document_type->id = $row['id'];
                $document_type->name = $row['name'];
                $document_type->created_at = $row['created_at'];
                $document_type->updated_at = $row['updated_at'];
                array_push($document_types, $document_type);
            }
            return [
                'status'=>200,
                'document_types'=>$document_types
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
            $document_type=[];
            $query = $this->db->connect()->prepare('SELECT * FROM document_types WHERE id=:id');
            $query->bindParam('id',$id);
            $query->execute();

            while ($row = $query->fetch()) {
                $document_type = new DocumentType();
                $document_type->id = $row['id'];
                $document_type->name = $row['name'];
                $document_type->created_at = $row['created_at'];
                $document_type->updated_at = $row['updated_at'];
                
            }
              
            return [
                'document_type' => $document_type,
                'status' =>200
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
            $query = $this->db->connect()->prepare('INSERT INTO document_types(name) VALUES (:name) ');
            if ($query->execute([
                'name' => $data['name']
            ])){
                return [
                    'status' => 200,
                    'message' => 'Nuevo tipo de documento creado'
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
                    'status' => 200,
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
                    'status' => 200,
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