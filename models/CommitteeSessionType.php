<?php

class CommitteeSessionType extends Model{
    public $id;
    public $name;
    public function __construct() {
        parent::__construct();
    }

    public function all()
    {
        try {
            $committee_session_types = [];
            $query = $this->db->connect()->query('SELECT * FROM committee_session_types');
            while($row = $query->fetch()){
                $committee_session_type = new CommitteeSessionType();
                $committee_session_type->id = $row['id'];
                $committee_session_type->name = $row['name'];
                array_push($committee_session_types, $committee_session_type);
            }
            return [
                'status'=>200,
                'committee_session_types' => $committee_session_types
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