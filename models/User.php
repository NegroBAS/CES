<?php

class User extends Model
{
    public $id;
    public $name;
    public $email;
    public $rol_id;
    public $rol_name;
    public $password;

    public function __construct()
    {
        parent::__construct();
    }

    public function all()
    {
        try {
            $users = [];
            $query = $this->db->connect()->query('SELECT users.id, users.name, users.email, users.rol_id, rols.name AS rol_name FROM users INNER JOIN rols ON users.rol_id = rols.id');
            while ($row = $query->fetch()) {
                $user = new User();
                $user->id = $row['id'];
                $user->name = $row['name'];
                $user->email = $row['email'];
                $user->rol_id = $row['rol_id'];
                $user->rol_name = $row['rol_name'];
                array_push($users, $user);
            }
            return [
                'status'=>200,
                'users'=>$users
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
            $query = $this->db->connect()->prepare('SELECT * FROM users WHERE id = :id');
            $query->execute([
                'id'=>$id
            ]);
            while($row = $query->fetch()){
                $user = new User();
                $user->id = $row['id'];
                $user->name = $row['name'];
                $user->email = $row['email'];
                $user->rol_id = $row['rol_id'];
            }
            return [
                'status'=>200,
                'user' => $user
            ];
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'error' => $e
            ];
        }
    }

    public function findSubdirector()
    {
        try {
            $query = $this->db->connect()->query("SELECT users.id, users.name, users.email, users.rol_id FROM users INNER JOIN rols ON rols.name = 'Subdirector'");
            while($row = $query->fetch()){
                $user = new User();
                $user->id = $row['id'];
                $user->name = $row['name'];
                $user->email = $row['email'];
                $user->rol_id = $row['rol_id'];
            }
            return [
                'status'=>200,
                'user'=>$user
            ];
        } catch (PDOException $e) {
            return [
                'status'=>500,
                'error'=>$e
            ];
        }
    }

    public function findByEmail($email)
    {
        try {
            $query = $this->db->connect()->prepare('SELECT * FROM users WHERE email = :email');
            $query->execute([
                'email'=>$email
            ]);
            while($row = $query->fetch()){
                $user = new User();
                $user->id = $row['id'];
                $user->name = $row['name'];
                $user->email = $row['email'];
                $user->rol_id = $row['rol_id'];
                $user->password = $row['password'];
            }
            return [
                'status'=>200,
                'user' => $user
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
            $query = $this->db->connect()->prepare('INSERT INTO users(name, email, rol_id, password) VALUES (:name, :email, :rol_id, :password)');
            $query->execute([
                'name'=>$data['name'],
                'email'=>$data['email'],
                'rol_id'=>$data['rol_id'],
                'password'=>$data['password']
            ]);
            return [
                'status'=>200,
                'message'=>'Nuevo usuario creado'
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
            $query = $this->db->connect()->prepare('UPDATE users SET name = :name, email = :email, rol_id = :rol_id WHERE id = :id');
            $query->execute([
                'name'=>$data['name'],
                'email'=>$data['email'],
                'rol_id'=>$data['rol_id'],
                'id'=>$data['id']
            ]);
            return [
                'status'=>200,
                'message'=>'Usuario actualizado'
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
            $query = $this->db->connect()->prepare('DELETE FROM users WHERE id = :id');
            $query->execute(['id'=>$id]);
            return [
                'status'=>200,
                'message'=>'Usuario eliminado'
            ];
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'error' => $e
            ];
        }
    }
}
