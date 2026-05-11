<?php
require_once __DIR__ . '/../../core/Database.php';

class VideoModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll()
    {
        return $this->db->query("SELECT * FROM videos")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUserId(int $userId)
    {
        return $this->db->query(
            "SELECT * FROM videos WHERE user_id = :user_id",
            [':user_id' => $userId]
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(string $title, string $description, string $filename, int $userId)
    {
        return $this->db->query(
            "INSERT INTO videos (title, description, filename, user_id) VALUES (:title, :description, :filename, :user_id)",
            [
                ':title'       => $title,
                ':description' => $description,
                ':filename'    => $filename,
                ':user_id'     => $userId,
            ]
        );
    }
}