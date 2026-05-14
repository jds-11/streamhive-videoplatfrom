<?php
require_once __DIR__ . '/../../core/Database.php';

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll()
    {
        return $this->db->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id)
    {
        return $this->db->query(
            "SELECT * FROM users WHERE id = :id",
            [':id' => $id]
        )->fetch(PDO::FETCH_ASSOC);
    }

    public function getByEmail(string $email)
    {
        return $this->db->query(
            "SELECT * FROM users WHERE email = :email",
            [':email' => $email]
        )->fetch(PDO::FETCH_ASSOC);
    }

    public function insert(string $email, string $password, string $role = 'user')
    {
        return $this->db->query(
            "INSERT INTO users (email, password, role) VALUES (:email, :password, :role)",
            [
                ':email'    => $email,
                ':password' => password_hash($password, PASSWORD_DEFAULT),
                ':role'     => $role,
            ]
        );
    }
}