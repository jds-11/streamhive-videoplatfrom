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

    public function getByResetToken(string $token)
    {
        return $this->db->query(
            "SELECT * FROM users WHERE reset_token = :token AND reset_expires > NOW()",
            [':token' => $token]
        )->fetch(PDO::FETCH_ASSOC);
    }

    public function setResetToken(string $email, string $token)
    {
        return $this->db->query(
            "UPDATE users SET reset_token = :token, reset_expires = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = :email",
            [':token' => $token, ':email' => $email]
        );
    }

    public function updatePassword(int $id, string $password)
    {
        return $this->db->query(
            "UPDATE users SET password = :password, reset_token = NULL, reset_expires = NULL WHERE id = :id",
            [':password' => password_hash($password, PASSWORD_DEFAULT), ':id' => $id]
        );
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