<?php

class Position extends Model{

    public $id;
    public $name;
    public $type;
    public $created_at;
    public $updated_at;

    public function __construct() {
        parent::__construct();
    }

    public function all()
    {
        try {
            $query = $this->db->connect()->query('SELECT * FROM positions');
            while ($row = $query->fetch()) {
                $position = new Position();
                $position->id = $row['id'];
                $position->name = $row['name'];
                $position->type = $row['type'];
                $position->created_at = $row['created_at'];
                $position->updated_at = $row['updated_at'];
                array_push($positions, $position);
            }
            return $positions;

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
            $query = $this->db->connect()->prepare('INSERT INTO positions(id, name,created_at,updated_at) VALUES (:id,:name, :created_at, :updated_at) ');
            if ($query->execute([
                'id'=>$data['id'],
                'name' => $data['name'],
                'type' => $data['type'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at']
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
        $position = [];
        try {
            $query = $this->db->connect()->prepare('SELECT * FROM positions WHERE id=:id');
            $query->bindParam('id', $id);
            $query->execute();

            while ($row = $query->fetch()) {
                $position = new Position();
                $position->id = $row['id'];
                $position->name = $row['name'];
                $position->type = $row['type'];
                $position->created_at = $row['created_at'];
                $position->updated_at = $row['updated_at'];
            }

            return $position;

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
            $query = $this->db->connect()->prepare('INSERT INTO positions(name,type,created_at,updated_at) VALUES (:name, :type, :created_at, :updated_at) ');
            if ($query->execute([
                'name' => $data['name'],
                'type' => $data['type'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at']
            ])) {
                return [
                    'status' => 'ok',
                    'message' => 'Nuevo Rango Creado'
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
            $query = $this->db->connect()->prepare('UPDATE positions SET name=:name ,type=:type, updated_at=:updated_at  WHERE id=:id ');
            if ($query->execute([
                'name' => $data['name'],
                'type' => $data['type'],
                'updated_at' => $data['updated_at'],
                'id' => $data['id']

            ])) {
                return [
                    'status' => 'ok',
                    'message' => 'Rango Actualizado '
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
            $query = $this->db->connect()->prepare('DELETE FROM positions WHERE id=:id ');
            if ($query->execute([
                'id' => $id
            ])) {
                return [
                    'status' => 'ok',
                    'message' => 'Rango Eliminado '
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