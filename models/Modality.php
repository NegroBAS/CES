<?php

class Modality extends Model
{

    public $id;
    public $name;
    public $created_at;
    public $updated_at;

    public function __construct()
    {
        parent::__construct();
    }

    public function all()
    {
        try {
            $modalities = [];
            $query = $this->db->connect()->query('SELECT * FROM modalities');
            while ($row = $query->fetch()) {
                $modality = new Modality();
                $modality->id = $row['id'];
                $modality->name = $row['name'];
                $modality->created_at = $row['created_at'];
                $modality->updated_at = $row['updated_at'];
                array_push($modalities, $modality);
            }
            return [
                'status' => 200,
                'modalities' => $modalities
            ];
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'error' => $e
            ];
        }
    }

    public function find($id)
    {
        try {
            $modality = [];
            $query = $this->db->connect()->prepare('SELECT * FROM modalities WHERE id=:id');
            $query->bindParam('id', $id);
            $query->execute();

            while ($row = $query->fetch()) {
                $modality = new Modality();
                $modality->id = $row['id'];
                $modality->name = $row['name'];
                $modality->created_at = $row['created_at'];
                $modality->updated_at = $row['updated_at'];
            }

            return [
                'modality' => $modality,
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
            $query = $this->db->connect()->prepare('INSERT INTO modalities(id, name,created_at,updated_at) VALUES (:id, :name, :created_at, :updated_at) ');
            if ($query->execute([
                'id'=>$data['id']?$data['id']:null,
                'name' => $data['name'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at']
            ])) {
                return [
                    'status' => 200,
                    'message' => 'Nueva Modalidad Creada'
                ];
            }
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'error' => $e
            ];
        }
    }
    public function update($data)
    {
        try {
            $query = $this->db->connect()->prepare('UPDATE modalities SET name=:name ,updated_at=:updated_at  WHERE id=:id ');
            if ($query->execute([
                'name' => $data['name'],
                'updated_at' => $data['updated_at'],
                'id' => $data['id']

            ])) {
                return [
                    'status' => 200,
                    'message' => 'Modalidad Actualizada '
                ];
            }
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'error' => $e
            ];
        }
    }

    public function delete($id)
    {
        try {
            $query = $this->db->connect()->prepare('DELETE FROM modalities   WHERE id=:id ');
            if ($query->execute([
                'id' => $id
            ])) {
                return [
                    'status' => 200,
                    'message' => 'Modalidad Eliminada '
                ];
            }
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'error' => $e
            ];
        }
    }
}
