<?php

class Committee extends Model{

    public $id;
    public $record_number;
    public $date;
    public $assistants;
    public $subdirector_name;
    public $qourum;
    public $start_hour;
    public $end_hour;
    public $place;
    public $formation_center;

    public function __construct() {
        parent::__construct();
    }

    public function all()
    {
        try {
            $committees = [];
            $query = $this->db->connect()->query('SELECT * FROM committees');
            while($row = $query->fetch()){
                $committee = new Committee();
                $committee->id = $row['id'];
                $committee->record_number = $row['record_number'];
                $committee->date = $row['date'];
                $committee->assistants = $row['assistants'];
                $committee->subdirector_name = $row['subdirector_name'];
                $committee->qourum = $row['qourum'];
                $committee->start_hour = $row['start_hour'];
                $committee->end_hour = $row['end_hour'];
                $committee->place = $row['place'];
                $committee->formation_center = $row['formation_center'];
                array_push($committees, $committee);
            }
            return [
                'status'=>200,
                'committees'=>$committees
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
            $query = $this->db->connect()->prepare('INSERT INTO committees(date, start_hour, end_hour, record_number, place, formation_center, assistants, qourum, subdirector_name) VALUES (:date, :start_hour, :end_hour, :record_number, :place, :formation_center, :assistants, :qourum, :subdirector_name)');
            $query->execute([
                'date'=>$data['date'],
                'start_hour'=>$data['start_hour'],
                'end_hour'=>$data['end_hour'],
                'record_number'=>$data['record_number'],
                'place'=>$data['place'],
                'formation_center'=>$data['formation_center'],
                'assistants'=>$data['assistants'],
                'qourum'=>$data['qourum'],
                'subdirector_name'=>$data['subdirector_name']
            ]);
            return [
                'status'=>200,
                'message'=>'Nuevo comité creado'
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