<?php

class FormationProgramType extends Model{

    public $id;
        public $name;
        public $elective_months;
        public $practice_months;
        public $created_at;
        public $updated_at;

    public function __construct() {
        parent::__construct();
    }

    public function all()
    {
        try {
            $Formation_program_types = [];
            $query = $this->db->connect()->query('SELECT * FROM formation_program_types');
            while ($row = $query->fetch()) {
                $Formation_program_type = new FormationProgramType();
                $Formation_program_type->id = $row['id'];
                $Formation_program_type->name = $row['name'];
                $Formation_program_type->elective_months = $row['elective_months'];
                $Formation_program_type->practice_months = $row['practice_months'];
                $Formation_program_type->created_at = $row['created_at'];
                $Formation_program_type->updated_at = $row['updated_at'];
                array_push($Formation_program_types, $Formation_program_type);
            }
            return $Formation_program_types;

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
            $Formation_program_type=[];
            $query = $this->db->connect()->prepare('SELECT * FROM formation_program_types WHERE id=:id');
            $query->bindParam('id',$id);
            $query->execute();

            while ($row = $query->fetch()) {
                $Formation_program_type = new FormationProgramType();
                $Formation_program_type->id = $row['id'];
                $Formation_program_type->name = $row['name'];
                $Formation_program_type->elective_months = $row['elective_months'];
                $Formation_program_type->practice_months = $row['practice_months'];
                $Formation_program_type->created_at = $row['created_at'];
                $Formation_program_type->updated_at = $row['updated_at'];
                
            }
              
            return [
               'formation_program_type'=> $Formation_program_type,
               'status'=>200
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
            $query = $this->db->connect()->prepare('INSERT INTO formation_program_types(name,elective_months,practice_months,created_at,updated_at) VALUES (:name,:elective_months,:practice_months,:created_at,:updated_at)');
            if ($query->execute([
                'name' => $data['name'],
                'elective_months' => $data['elective_months'],
                'practice_months' => $data['practice_months'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at']
            ])){
                return [
                    'status' => 200,
                    'message' => 'Nuevo Tipo Programa Formacion Creado'
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
            $query = $this->db->connect()->prepare('UPDATE formation_program_types SET name=:name ,elective_months=:elective_months,practice_months=:practice_months,updated_at=:updated_at  WHERE id=:id ');
            if ($query->execute([
                'name' =>$data['name'],
                'elective_months' =>$data['elective_months'],
                'practice_months' =>$data['practice_months'],
                'updated_at' => $data['updated_at'],
                'id' => $data['id']
                
            ])){
                return [
                    'status' => 200,
                    'message' => 'Tipo Programa Formacion Actualizado '
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
            $query = $this->db->connect()->prepare('DELETE FROM formation_program_types WHERE id=:id ');
            if ($query->execute([
                'id' =>$id
            ])){
                return [
                    'status' => 200,
                    'message' => 'Tipo Programa Formacion Eliminado '
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