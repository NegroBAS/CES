<?php

class CommitteeSessionState extends Model{

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
            $comitte_session_states = [];
            $query = $this->db->connect()->query('SELECT * FROM committee_session_states');
            while ($row = $query->fetch()) {
                $comitte_session_state = new CommitteeSessionState();
                $comitte_session_state->id = $row['id'];
                $comitte_session_state->name = $row['name'];
                $comitte_session_state->created_at = $row['created_at'];
                $comitte_session_state->updated_at = $row['updated_at'];
                array_push($comitte_session_states, $comitte_session_state);
            }
            return [
                'comitte_session_states'=> $comitte_session_states,
                'status' => 200
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
            $query = $this->db->connect()->prepare("INSERT INTO committee_session_states(name) VALUES (:name)");
            $query->execute([
                'name'=>$data['name']
            ]);
            return [
                'status'=>200,
                'message'=>'Nuevo estado de comité creado'
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