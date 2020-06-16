<?php

class Group extends Model{

    public $id;
    public $code_tab;
    public $modality_id;
    public $formation_program_id;
    public $quantity_learners;
    public $active_learners;
    public $elective_start_date;
    public $elective_end_date;
    public $practice_start_date;
    public $practice_end_date;
    public $created_at;
    public $updated_at;

    public function __construct() {
        parent::__construct();
    }

    public function all()
    {
        try {
            $groups = [];
            $query = $this->db->connect()->query('SELECT *,groups.id, modalities.id as id_modalities, modalities.name as name_modalities ,
            formation_programs.id as id_formation, formation_programs.name as name_formation FROM groups
            INNER JOIN modalities ON groups.modality_id = modalities.id
            INNER JOIN formation_programs ON groups.formation_program_id = formation_programs.id ');
            while ($row = $query->fetch()) {
                $group = new Group();
                $group->id = $row['id'];
                $group->code_tab = $row['code_tab'];
                $group->modality_id = $row['modality_id'];
                $group->formation_program_id = $row['formation_program_id'];
                $group->quantity_learners = $row['quantity_learners'];
                $group->active_learners = $row['active_learners'];
                $group->elective_start_date = $row['elective_start_date'];
                $group->elective_end_date = $row['elective_end_date'];
                $group->practice_start_date = $row['practice_start_date'];
                $group->practice_end_date = $row['practice_end_date'];
                $group->created_at = $row['created_at'];
                $group->updated_at = $row['updated_at'];
                $group->id_modalities = $row['id_modalities'];
                $group->name_modalities = $row['name_modalities'];
                $group->id_formation = $row['id_formation'];
                $group->name_formation = $row['name_formation'];
                array_push($groups, $group);
            }
            return [
                'status'=>200,
                'groups'=>$groups
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
            $group=[];
            $query = $this->db->connect()->prepare('SELECT * FROM groups WHERE id=:id');
            $query->bindParam('id',$id);
            $query->execute();

            while ($row = $query->fetch()) {
                $group = new Group();
                $group->id = $row['id'];
                $group->code_tab = $row['code_tab'];
                $group->modality_id = $row['modality_id'];
                $group->formation_program_id = $row['formation_program_id'];
                $group->quantity_learners = $row['quantity_learners'];
                $group->active_learners = $row['active_learners'];
                $group->elective_start_date = $row['elective_start_date'];
                $group->elective_end_date = $row['elective_end_date'];
                $group->practice_start_date = $row['practice_start_date'];
                $group->practice_end_date = $row['practice_end_date'];
                $group->created_at = $row['created_at'];
                $group->updated_at = $row['updated_at'];
                
            }
              
            return [
                'group' => $group,
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
            $query = $this->db->connect()->prepare('INSERT INTO groups
            (code_tab,modality_id,formation_program_id,quantity_learners,active_learners,elective_start_date,elective_end_date,practice_start_date,practice_end_date,created_at,updated_at) 
            VALUES (:code_tab,:modality_id,:formation_program_id,:quantity_learners,:active_learners,:elective_start_date,:elective_end_date,:practice_start_date,:practice_end_date,:created_at,:updated_at)');
            if ($query->execute([
                'code_tab' => $data['code_tab'],
                'modality_id'=>$data['modality_id'],
                'formation_program_id'=>$data['formation_program_id'],
                'quantity_learners' => $data['quantity_learners'],
                'active_learners' => $data['active_learners'],
                'elective_start_date' => $data['elective_start_date'],
                'elective_end_date' => $data['elective_end_date'],
                'practice_start_date' => $data['practice_start_date'],
                'practice_end_date' => $data['practice_end_date'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at']
            ])){
                return [
                    'status' => 200,
                    'message' => 'Grupo creado '
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
            $query = $this->db->connect()->prepare('UPDATE groups  SET code_tab=:code_tab,modality_id=:modality_id,formation_program_id=:formation_program_id,
            quantity_learners=:quantity_learners,active_learners=:active_learners,elective_start_date=:elective_start_date,elective_end_date=:elective_end_date,
            practice_start_date=:practice_start_date,practice_end_date=:practice_end_date,updated_at=:updated_at  WHERE id=:id ');
            if ($query->execute([
                'code_tab' =>$data['code_tab'],
                'modality_id' => $data['modality_id'],
                'formation_program_id' => $data['formation_program_id'],
                'quantity_learners' => $data['quantity_learners'],
                'active_learners' => $data['active_learners'],
                'elective_start_date' => $data['elective_start_date'],
                'elective_end_date' => $data['elective_end_date'],
                'practice_start_date' => $data['practice_start_date'],
                'practice_end_date' => $data['practice_end_date'],
                'updated_at' => $data['updated_at'],
                'id' => $data['id']
                
            ]))
                return [
                    'status' => 200,
                    'message' => 'Grupo actualizado'
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
            $query = $this->db->connect()->prepare('DELETE FROM groups  WHERE id=:id ');
            if ($query->execute([
                'id' =>$id
            ])){
                return [
                    'status' => 200,
                    'message' => 'Grupo eliminado '
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