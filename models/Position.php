<?php

class Position extends Model{

    public $id;
    public $name;
    public $type;

    public function __construct() {
        parent::__construct();
    }

    public function all()
    {
       
        try {
            
            $positions = [];
            $query = $this->db->connect()->query('SELECT * FROM positions');
            while($row = $query->fetch()){
                $position = new Position();
                $position->id = $row['id'];
                $position->name = $row['name'];
                $position->type = $row['type'];
                array_push($positions, $position);
            }
            return [
                'status'=>200,
                'positions'=>$positions
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
            $query = $this->db->connect()->prepare('INSERT INTO positions(name, type) VALUES (:name, :type)');
            $query->execute([
                'name'=>$data['name'],
                'type'=>$data['type']
            ]);
            return [
                'status'=>200,
                'message'=>'Nuevo cargo creado'
            ];
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
            $query = $this->db->connect()->prepare('UPDATE positions SET name=:name ,type=:type WHERE id=:id ');
            if ($query->execute([
                'name' => $data['name'],
                'type' => $data['type'],
                'id' => $data['id']

            ])) {
                return [
                    'status' => 200,
                    'message' => 'Cargo Actualizado '
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
                    'status' => 200,
                    'message' => 'Cargo Eliminado '
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