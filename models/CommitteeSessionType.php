<?php

class CommitteeSessionType extends Model{
    public $id;
    public $name;
    public function __construct() {
        parent::__construct();
    }

    public function all()
    {
        try {
            $committee_session_types = [];
            $query = $this->db->connect()->query('SELECT * FROM committee_session_types');
            while($row = $query->fetch()){
                $committee_session_type = new CommitteeSessionType();
                $committee_session_type->id = $row['id'];
                $committee_session_type->name = $row['name'];
                array_push($committee_session_types, $committee_session_type);
            }
            return [
                'status'=>200,
                'committee_session_types' => $committee_session_types
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
            $committee_session_type = [];
            $query = $this->db->connect()->prepare('SELECT * FROM committee_session_types WHERE id=:id');
            $query->bindParam('id', $id);
            $query->execute();

            while ($row = $query->fetch()) {
                $committee_session_type = new CommitteeSessionType();
                $committee_session_type->id = $row['id'];
                $committee_session_type->name = $row['name'];
                $committee_session_type->created_at = $row['created_at'];
                $committee_session_type->updated_at = $row['updated_at'];
            }

            return [
                'committee_session_type'=>$committee_session_type,
                'status' => 200
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
            $query = $this->db->connect()->prepare('INSERT INTO committee_session_types(name,created_at,updated_at) VALUES (:name, :created_at, :updated_at) ');
            if ($query->execute([
                'name' => $data['name'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at']
            ])) {
                return [
                    'status' => 200,
                    'message' => 'Nuevo tipo de comité creado'
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
            $query = $this->db->connect()->prepare('UPDATE committee_session_types SET name=:name,updated_at=:updated_at WHERE id=:id ');
            if ($query->execute([
                'name' => $data['name'],
                'updated_at' => $data['updated_at'],
                'id' => $data['id']

            ])) {
                return [
                    'status' => 200,
                    'message' => 'Tipo de comité actualizado '
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
            $query = $this->db->connect()->prepare('DELETE FROM committee_session_types WHERE id=:id ');
            if ($query->execute([
                'id' => $id
            ])) {
                return [
                    'status' => 200,
                    'message' => 'Tipo de comité eliminado '
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