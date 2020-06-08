<?php

class Rol extends Model
{
    public $id;
    public $name;
    public function __construct()
    {
        parent::__construct();
    }

    public function all()
    {
        try {
            $rols = [];
            $query = $this->db->connect()->query('SELECT * FROM rols');
            while ($row = $query->fetch()) {
                $rol = new Rol();
                $rol->id = $row['id'];
                $rol->name = $row['name'];
                array_push($rols, $rol);
            }
            return [
                'status'=>200,
                'rols' => $rols
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
            $query = $this->db->connect()->prepare('SELECT * FROM rols WHERE id = :id');
            $query->execute([
                'id'=>$id
            ]);
            while($row = $query->fetch()){
                $rol = new Rol();
                $rol->id = $row['id'];
                $rol->name = $row['name'];
            }
            return [
                'status'=>200,
                'rol' => $rol
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
            $query = $this->db->connect()->prepare('INSERT INTO rols(name) VALUES (:name)');
            $query->execute([
                'name' => $data['name']
            ]);
            return [
                'status'=>200,
                'message' => 'Nuevo rol creado'
            ];
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
            $query = $this->db->connect()->prepare('UPDATE rols SET name = :name WHERE id = :id');
            $query->execute([
                'name'=>$data['name'],
                'id'=>$data['id']
            ]);
            return [
                'status'=>200,
                'message'=>'Rol editado'
            ];
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
            $query = $this->db->connect()->prepare('DELETE FROM rols WHERE id = :id');
            $query->execute([
                'id' => $id
            ]);
            return [
                'status'=>200,
                'message' => 'Rol eliminado'
            ];
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'error' => $e
            ];
        }
    }
}
