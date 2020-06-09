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
        $positions = [];
        try {
            $query = $this->db->connect()->query('SELECT * FROM positions');
            while($row = $query->fetch()){
                $position = new Position();
                $position->id = $row['id'];
                $position->name = $row['name'];
                $position->type = $row['position'];
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
        try {

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
            
        } catch (PDOException $e) {
            return [
                'status'=>500,
                'error' => $e
            ];
        }
    }
}