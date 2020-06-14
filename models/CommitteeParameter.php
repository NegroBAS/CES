<?php

class CommitteeParameter extends Model{

        public $id;
        public $name;
        public $content;
        public $committee_session_state_id;
        public $created_at;
        public $updated_at;

    public function __construct() {
        parent::__construct();
    }

    public function all()
    {
        try {
            $comitte_parameters = [];
            $query = $this->db->connect()->query('SELECT committee_parameters.id,committee_parameters.name,committee_parameters.content,committee_parameters.committee_session_state_id,committee_parameters.created_at,
            committee_parameters.updated_at, committee_session_states.id as id_state,committee_session_states.name as name_state FROM committee_parameters INNER JOIN committee_session_states
             ON committee_parameters.committee_session_state_id = committee_session_states.id ');
            while ($row = $query->fetch()) {
                $parameters = new CommitteeParameter();
                $parameters->id = $row['id'];
                $parameters->name = $row['name'];
                $parameters->content = $row['content'];
                $parameters->committee_session_state_id = $row['committee_session_state_id'];
                $parameters->created_at = $row['created_at'];
                $parameters->updated_at = $row['updated_at'];
                $parameters->id_state = $row['id_state'];
                $parameters->name_state = $row['name_state'];
                array_push($comitte_parameters, $parameters);
            }

            return $comitte_parameters;

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
            $parameters=[];
            $query = $this->db->connect()->prepare('SELECT * FROM committee_parameters WHERE id=:id');
            $query->bindParam('id',$id);
            $query->execute();

            while ($row = $query->fetch()) {
                $parameters = new CommitteeParameter();
                $parameters->id = $row['id'];
                $parameters->name = $row['name'];
                $parameters->content = $row['content'];
                $parameters->committee_session_state_id = $row['committee_session_state_id'];
                $parameters->created_at = $row['created_at'];
                $parameters->updated_at = $row['updated_at'];
                
            }
              
            return [
                'parameters'=>$parameters,
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
            $query = $this->db->connect()->prepare('INSERT INTO committee_parameters(name,content,committee_session_state_id,created_at,updated_at) VALUES (:name,:content,:committee_session_state_id,:created_at,:updated_at)');
            if ($query->execute([
                'name' => $data['name'],
                'content'=>$data['content'],
                'committee_session_state_id'=>$data['committee_session_state_id'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at']
            ])){
                return [
                    'status' => 200,
                    'message' => 'Parametro de comite creado '
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
            $query = $this->db->connect()->prepare('UPDATE committee_parameters SET name=:name,content=:content,committee_session_state_id=:committee_session_state_id,updated_at=:updated_at  WHERE id=:id ');
            if ($query->execute([
                'name' =>$data['name'],
                'content' =>$data['content'],
                'committee_session_state_id' =>$data['committee_session_state_id'],
                'updated_at' => $data['updated_at'],
                'id' => $data['id']
                
            ])){
                return [
                    'status' => 200,
                    'message' => 'Parametro  actualizado '
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
            $query = $this->db->connect()->prepare('DELETE FROM committee_parameters   WHERE id=:id ');
            if ($query->execute([
                'id' =>$id
            ])){
                return [
                    'status' => 200,
                    'message' => 'parametro eliminado '
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