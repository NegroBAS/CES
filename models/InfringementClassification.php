<?php

class InfringementClassification extends Model{

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
            $infringement_classifications = [];
            $query = $this->db->connect()->query('SELECT * FROM infringement_classifications');
            while ($row = $query->fetch()) {
                $infringement_classification = new InfringementClassification();
                $infringement_classification->id = $row['id'];
                $infringement_classification->name = $row['name'];
                $infringement_classification->created_at = $row['created_at'];
                $infringement_classification->updated_at = $row['updated_at'];
                array_push($infringement_classifications, $infringement_classification);
            }
            return [
                'infringement_classifications' => $infringement_classifications,
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
            $infringement_classification=[];
            $query = $this->db->connect()->prepare('SELECT * FROM infringement_classifications WHERE id=:id');
            $query->bindParam('id',$id);
            $query->execute();

            while ($row = $query->fetch()) {
                $infringement_classification = new InfringementClassification();
                $infringement_classification->id = $row['id'];
                $infringement_classification->name = $row['name'];
                $infringement_classification->created_at = $row['created_at'];
                $infringement_classification->updated_at = $row['updated_at'];
                
            }
              
            return [
                'infringement_classification'=>$infringement_classification,
                'status'=>200
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
            $query = $this->db->connect()->prepare('INSERT INTO infringement_classifications(name,created_at,updated_at) VALUES (:name, :created_at, :updated_at) ');
            if ($query->execute([
                'name' => $data['name'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at']
            ])){
                return [
                    'status' => 200,
                    'message' => 'Nuevo clasificacion creada'
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
            $query = $this->db->connect()->prepare('UPDATE infringement_classifications SET name=:name ,updated_at=:updated_at  WHERE id=:id ');
            if ($query->execute([
                'name' =>$data['name'],
                'updated_at' => $data['updated_at'],
                'id' => $data['id']
                
            ])){
                return [
                    'status' => 200,
                    'message' => 'Clasificacion actualizada '
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
            $query = $this->db->connect()->prepare('DELETE FROM infringement_classifications   WHERE id=:id ');
            if ($query->execute([
                'id' =>$id
            ])){
                return [
                    'status' => 200,
                    'message' => 'Clasificacion eliminada '
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