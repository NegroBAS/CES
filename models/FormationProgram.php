<?php

class FormationProgram extends Model{

    public $id;
    public $name;
    public $code;
    public $formation_program_type_id;
    public $created_at;
    public $updated_at;

    public function __construct() {
        parent::__construct();
    }

    public function all()
    {
        try {
            $programs = [];
            $query = $this->db->connect()->query('SELECT formation_programs.id,formation_programs.code,formation_programs.name,
            formation_programs.formation_program_type_id,formation_programs.created_at,formation_programs.updated_at,
            formation_program_types.id as id_formation, formation_program_types.name as name_formation FROM formation_programs
            INNER JOIN formation_program_types ON formation_programs.formation_program_type_id = formation_program_types.id');
            while ($row = $query->fetch()) {
                $program = new FormationProgram();
                $program->id = $row['id'];
                $program->code = $row['code'];
                $program->name = $row['name'];
                $program->formation_program_type_id = $row['formation_program_type_id'];
                $program->created_at = $row['created_at'];
                $program->updated_at = $row['updated_at'];
                $program->id_formation = $row['id_formation'];
                $program->name_formation = $row['name_formation'];
                array_push($programs, $program);
            }
            return $programs;
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
            $program=[];
            $query = $this->db->connect()->prepare('SELECT * FROM formation_programs WHERE id=:id');
            $query->bindParam('id',$id);
            $query->execute();

            while ($row = $query->fetch()) {
                $program = new FormationProgram();
                $program->id = $row['id'];
                $program->code = $row['code'];
                $program->name = $row['name'];
                $program->formation_program_type_id = $row['formation_program_type_id'];
                $program->created_at = $row['created_at'];
                $program->updated_at = $row['updated_at'];
                
            }
            return $program;
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
            $query = $this->db->connect()->prepare('INSERT INTO formation_programs(code,name,formation_program_type_id,created_at,updated_at) VALUES (:code, :name, :formation_program_type_id, :created_at, :updated_at) ');
            if ($query->execute([
                'code' => $data['code'],
                'name' => $data['name'],
                'formation_program_type_id' => $data['formation_program_type_id'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at']
            ])){
                return [
                    'status' => 'ok',
                    'message' => 'Nuevo Programa de Formacion Creado'
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
            $query = $this->db->connect()->prepare('UPDATE formation_programs SET code=:code, name=:name, formation_program_type_id=:formation_program_type_id, updated_at=:updated_at  WHERE id=:id ');
            if ($query->execute([
                'code' =>$data['code'],
                'name' =>$data['name'],
                'formation_program_type_id' =>$data['formation_program_type_id'],
                'updated_at' => $data['updated_at'],
                'id' => $data['id']
                
            ])){
                return [
                    'status' => 'ok',
                    'message' => 'Programa Actualizado '
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
            $query = $this->db->connect()->prepare('DELETE FROM formation_programs   WHERE id=:id ');
            if ($query->execute([
                'id' =>$id
            ])){
                return [
                    'status' => 'ok',
                    'message' => 'Programa Eliminado '
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