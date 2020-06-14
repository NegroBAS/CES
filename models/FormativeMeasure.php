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
            $formatives = [];
            $query = $this->db->connect()->query('SELECT * FROM formative_measures');
            while ($row = $query->fetch()) {
                $formative = new FormativeMeasure();
                $formative->id = $row['id'];
                $formative->name = $row['name'];
                $formative->created_at = $row['created_at'];
                $formative->updated_at = $row['updated_at'];
                array_push($formatives, $formative);
            }
            return $formatives;

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
            $contract = [];
            $query = $this->db->connect()->prepare('SELECT * FROM formative_measures WHERE id=:id');
            $query->bindParam('id', $id);
            $query->execute();

            while ($row = $query->fetch()) {
                $contract = new FormativeMeasure();
                $contract->id = $row['id'];
                $contract->name = $row['name'];
                $contract->created_at = $row['created_at'];
                $contract->updated_at = $row['updated_at'];
            }

            return [
                'measure'=>$contract,
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
                'name' => $data['name'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at']
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