<?php

class Learner extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function all()
    {
        $learners = [];
        try {
            $query = $this->db->connect()->query('SELECT * FROM learners');
            while ($row = $query->fetch()) {
                $learner = new Learner();
                $learner->id = $row['id'];
                $learner->username = $row['username'];
                $learner->document_type = $row['document_type'];
                $learner->document = $row['document'];
                $learner->phone = $row['phone'];
                $learner->email = $row['email'];
                $learner->group_id = $row['group_id'];
                $learner->birthdate = $row['group_id'];
                $learner->photo = $row['photo'];
                array_push($learners, $learner);
            }
            return [
                'status' => 200,
                'learners' => $learners
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
            $query = $this->db->connect()->prepare('SELECT 
                learners.*,
                groups.id AS group_id,
                groups.code_tab AS group_code_tab,
                groups.modality_id AS group_modality_id,
                groups.formation_program_id AS group_formation_program_id,
                groups.quantity_learners AS group_quantity_learners,
                groups.active_learners AS group_active_learners,
                groups.elective_start_date AS group_elective_start_date,
                groups.elective_end_date AS group_elective_end_date,
                groups.practice_start_date AS group_practice_start_date,
                groups.practice_end_date AS group_practice_end_date,
                formation_programs.id AS formation_program_id,
                formation_programs.code AS formation_program_code,
                formation_programs.name AS formation_program_name,
                formation_programs.formation_program_type_id AS formation_program_formation_program_type_id,
                modalities.id AS modality_id,
                modalities.name AS modality_name,
                formation_program_types.id AS formation_program_type_id,
                formation_program_types.name AS formation_program_type_name,
                formation_program_types.elective_months AS formation_program_type_elective_months,
                formation_program_types.practice_months AS formation_program_type_practice_months
                FROM learners 
                INNER JOIN groups ON groups.id = learners.group_id
                INNER JOIN formation_programs ON formation_programs.id = groups.formation_program_id
                INNER JOIN formation_program_types ON formation_program_types.id = formation_programs.formation_program_type_id
                INNER JOIN modalities ON modalities.id = groups.modality_id
                WHERE learners.id = :id'
            );
            $query->execute([
                'id' => $id
            ]);
            while ($row = $query->fetch()) {
                $learner = new Learner();
                $learner->id = $row['id'];
                $learner->username = $row['username'];
                $learner->document_type = $row['document_type'];
                $learner->document = $row['document'];
                $learner->phone = $row['phone'];
                $learner->email = $row['email'];
                $learner->group_id = $row['group_id'];
                $learner->group = [
                    'id'=>$row['group_id'],
                    'code_tab'=>$row['group_code_tab'],
                    'modality_id'=>$row['group_modality_id'],
                    'modality'=>[
                        'id'=>$row['modality_id'],
                        'name'=>$row['modality_name'],
                    ],
                    'formation_program_id'=>$row['group_formation_program_id'],
                    'formation_program'=>[
                        'id'=>$row['formation_program_id'],
                        'code'=>$row['formation_program_code'],
                        'name'=>$row['formation_program_name'],
                        'formation_program_type_id'=>$row['formation_program_formation_program_type_id'],
                        'formation_program_type'=>[
                            'id'=>$row['formation_program_type_id'],
                            'name'=>$row['formation_program_type_name'],
                            'elective_months'=>$row['formation_program_type_elective_months'],
                            'practice_months'=>$row['formation_program_type_practice_months'],
                        ],
                    ],
                    'quantity_learners'=>$row['group_quantity_learners'],
                    'active_learners'=>$row['group_active_learners'],
                    'elective_start_date'=>$row['group_elective_start_date'],
                    'elective_end_date'=>$row['group_elective_end_date'],
                    'practice_start_date'=>$row['group_practice_start_date'],
                    'practice_end_date'=>$row['group_practice_end_date'],
                ];
                $learner->birthdate = $row['birthdate'];
                $learner->photo = $row['photo'];
            }
            return [
                'status' => 200,
                'learner' => $learner
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
            $query = $this->db->connect()->prepare('INSERT INTO learners(username, document_type, document, phone, email, group_id, birthdate, photo) VALUES (:username, :document_type, :document, :phone, :email, :group_id, :birthdate, :photo)');
            $query->execute([
                'username' => $data['username'],
                'document_type' => $data['document_type'],
                'document' => $data['document'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'group_id' => $data['group_id'],
                'birthdate' => $data['birthdate'],
                'photo' => isset($data['photo'])?$data['photo']:null
            ]);
            return [
                'status' => 200,
                'message' => 'Nuevo aprendiz agregado'
            ];
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'error' => $e
            ];
        }
    }

    public function create_csv($data)
    {
        try {
            $query = $this->db->connect()->prepare('INSERT INTO learners(username, document_type, document, phone, email, group_id) VALUES (:username, :document_type, :document, :phone, :email, :group_id)');
            $query->execute([
                'username' => $data['username'],
                'document_type' => $data['document_type'],
                'document' => $data['document'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'group_id' => $data['group_id']
            ]);
            return [
                'status' => 200,
                'message' => 'Aprendices agregados por CSV'
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
            $query = $this->db->connect()->prepare('UPDATE learners SET username = :username, document_type = :document_type, document = :document, phone = :phone, email = :email, group_id = :group_id, birthdate = :birthdate, photo = :photo WHERE id = :id');
            $query->execute([
                'username' => $data['username'],
                'document_type' => $data['document_type'],
                'document' => $data['document'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'group_id' => $data['group_id'],
                'birthdate' => $data['birthdate'],
                'photo' => $data['photo'],
                'id' => $data['id']
            ]);
            return [
                'status' => 200,
                'message' => 'Aprendiz actualizado'
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
            $query = $this->db->connect()->prepare('DELETE FROM learners WHERE id = :id');
            $query->execute([
                'id' => $id
            ]);
            return [
                'status' => 200,
                'message' => 'Aprendiz eliminado'
            ];
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'error' => $e
            ];
        }
    }
}
