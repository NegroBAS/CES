<?php

class InfringementType extends Model{

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
            $infringements = [];
            $query = $this->db->connect()->query('SELECT * FROM infringement_types');
            while ($row = $query->fetch()) {
                $infringement = new InfringementType();
                $infringement->id = $row['id'];
                $infringement->name = $row['name'];
                $infringement->created_at = $row['created_at'];
                $infringement->updated_at = $row['updated_at'];
                array_push($infringements, $infringement);
            }
            return $infringements;

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
            $type = [];
            $query = $this->db->connect()->prepare('SELECT * FROM infringement_types WHERE id=:id');
            $query->bindParam('id', $id);
            $query->execute();

            while ($row = $query->fetch()) {
                $type = new InfringementType();
                $type->id = $row['id'];
                $type->name = $row['name'];
                $type->created_at = $row['created_at'];
                $type->updated_at = $row['updated_at'];
            }

            return [
                'type' => $type,
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
            $query = $this->db->connect()->prepare('INSERT INTO infringement_types(name,created_at,updated_at) VALUES (:name, :created_at, :updated_at) ');
            if ($query->execute([
                'name' => $data['name'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at']
            ])) {
                return [
                    'status' => 200,
                    'message' => 'Tipo falta creada'
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
            $query = $this->db->connect()->prepare('UPDATE infringement_types SET name=:name ,updated_at=:updated_at  WHERE id=:id ');
            if ($query->execute([
                'name' => $data['name'],
                'updated_at' => $data['updated_at'],
                'id' => $data['id']

            ])) {
                return [
                    'status' => 200,
                    'message' => 'Tipo falta actualizada'
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
            $query = $this->db->connect()->prepare('DELETE FROM infringement_types WHERE id=:id ');
            if ($query->execute([
                'id' => $id
            ])) {
                return [
                    'status' => 200,
                    'message' => 'Tipo falta eliminada '
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