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
                $modalitie = new Modality();
                $modalitie->id = $row['id'];
                $modalitie->name = $row['name'];
                $modalitie->created_at = $row['created_at'];
                $modalitie->updated_at = $row['updated_at'];
                array_push($modalities, $modalitie);
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
            $modalitie = [];
            $query = $this->db->connect()->prepare('SELECT * FROM modalities WHERE id=:id');
            $query->bindParam('id', $id);
            $query->execute();

            while ($row = $query->fetch()) {
                $modalitie = new Modality();
                $modalitie->id = $row['id'];
                $modalitie->name = $row['name'];
                $modalitie->created_at = $row['created_at'];
                $modalitie->updated_at = $row['updated_at'];
            }

            return [
                'modalities' => $modalitie,
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
            $query = $this->db->connect()->prepare('INSERT INTO modalities(name,created_at,updated_at) VALUES (:name, :created_at, :updated_at) ');
            if ($query->execute([
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
