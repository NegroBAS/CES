<?php

class Sanction extends Model{

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
             $sanctions = [];
            $query = $this->db->connect()->query('SELECT * FROM sanctions');
            while ($row = $query->fetch()) {
                $sanction = new Sanction();
                $sanction->id = $row['id'];
                $sanction->name = $row['name'];
                $sanction->created_at = $row['created_at'];
                $sanction->updated_at = $row['updated_at'];
                array_push($sanctions, $sanction);
            }
            return [
                'sanctions' => $sanctions,
                'status' => 200
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
            $sanction=[];
            $query = $this->db->connect()->prepare('SELECT * FROM sanctions WHERE id=:id');
            $query->bindParam('id',$id);
            $query->execute();

            while ($row = $query->fetch()) {
                $sanction = new Sanction();
                $sanction->id = $row['id'];
                $sanction->name = $row['name'];
                $sanction->created_at = $row['created_at'];
                $sanction->updated_at = $row['updated_at'];
                
            }
              
            return [
                'sanction'=>$sanction,
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
            $query = $this->db->connect()->prepare('INSERT INTO sanctions(name,created_at,updated_at) VALUES (:name, :created_at, :updated_at) ');
            if ($query->execute([
                'name' => $data['name'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at']
            ])){
                return [
                    'status' => 200,
                    'message' => 'Nueva Sancion Creada'
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
            $query = $this->db->connect()->prepare('UPDATE sanctions SET name=:name ,updated_at=:updated_at  WHERE id=:id ');
            if ($query->execute([
                'name' =>$data['name'],
                'updated_at' => $data['updated_at'],
                'id' => $data['id']
                
            ])){
                return [
                    'status' => 200,
                    'message' => 'Sancion Actualizada '
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
            $query = $this->db->connect()->prepare('DELETE FROM sanctions   WHERE id=:id ');
            if ($query->execute([
                'id' =>$id
            ])){
                return [
                    'status' => 200,
                    'message' => 'Sancion Eliminada '
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