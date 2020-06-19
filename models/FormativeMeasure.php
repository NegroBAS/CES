<?php

class FormativeMeasure extends Model{

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
            $formative_measures = [];
            $query = $this->db->connect()->query('SELECT * FROM formative_measures');
            while ($row = $query->fetch()) {
                $formative_measure = new FormativeMeasure();
                $formative_measure->id = $row['id'];
                $formative_measure->name = $row['name'];
                $formative_measure->created_at = $row['created_at'];
                $formative_measure->updated_at = $row['updated_at'];
                array_push($formative_measures, $formative_measure);
            }
            return [
                'formative_measures' => $formative_measures,
                'status'=> 200
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
            $formative_measure = [];
            $query = $this->db->connect()->prepare('SELECT * FROM formative_measures WHERE id=:id');
            $query->bindParam('id', $id);
            $query->execute();

            while ($row = $query->fetch()) {
                $formative_measure = new FormativeMeasure();
                $formative_measure->id = $row['id'];
                $formative_measure->name = $row['name'];
                $formative_measure->created_at = $row['created_at'];
                $formative_measure->updated_at = $row['updated_at'];
            }

            return [
                'formative_measure'=>$formative_measure,
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
            $query = $this->db->connect()->prepare('INSERT INTO formative_measures(name,created_at,updated_at) VALUES (:name, :created_at, :updated_at) ');
            if ($query->execute([
                'name' => $data['name']
            ])) {
                return [
                    'status' => 200,
                    'message' => 'Nueva medida formativa creada'
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
            $query = $this->db->connect()->prepare('UPDATE formative_measures SET name=:name ,updated_at=:updated_at  WHERE id=:id ');
            if ($query->execute([
                'name' => $data['name'],
                'updated_at' => $data['updated_at'],
                'id' => $data['id']

            ])) {
                return [
                    'status' => 200,
                    'message' => 'Medida formativa actualizada '
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
            $query = $this->db->connect()->prepare('DELETE FROM formative_measures  WHERE id=:id ');
            if ($query->execute([
                'id' => $id
            ])) {
                return [
                    'status' => 200,
                    'message' => 'Medida formativa eliminado '
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