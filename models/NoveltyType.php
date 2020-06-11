<?php

class NoveltyType extends Model{

    public function __construct() {
        parent::__construct();
    }

    public function all()
    {
        try {
            $novelty_types = [];
            $query = $this->db->connect()->query('SELECT * FROM novelty_types');
            while($row = $query->fetch()){
                $novelty_type = new NoveltyType();
                $novelty_type->id = $row['id'];
                $novelty_type->name = $row['name'];
                array_push($novelty_types, $novelty_type);
            }
            return [
                'status'=>200,
                'novelty_types'=>$novelty_types
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
            $query = $this->db->connect()->prepare('SELECT * FROM novelty_types WHERE id = :id');
            $query->execute([
                'id'=>$id
            ]);
            while($row = $query->fetch()){
                $novelty_type = new NoveltyType();
                $novelty_type->id = $row['id'];
                $novelty_type->name = $row['name'];
            }
            return [
                'status'=>200,
                'novelty_type'=>$novelty_type
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
            $query = $this->db->connect()->prepare('INSERT INTO novelty_types(name) VALUES (:name)');
            $query->execute([
                'name'=>$data['name']
            ]);
            return [
                'status'=>200,
                'message'=>'Nueva novedad creada'
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
            $query = $this->db->connect()->prepare('UPDATE novelty_types SET name = :name WHERE id = :id');
            $query->execute([
                'name'=>$data['name'],
                'id'=>$data['id']
            ]);
            return [
                'status'=>200,
                'message'=>'Novedad actualizada'
            ];
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
            $query = $this->db->connect()->prepare('DELETE FROM novelty_types WHERE id = :id');
            $query->execute([
                'id'=>$id
            ]);
            return [
                'status'=>200,
                'message'=>'Tipo de novedad eliminada'
            ];
        } catch (PDOException $e) {
            return [
                'status'=>500,
                'error' => $e
            ];
        }
    }
}