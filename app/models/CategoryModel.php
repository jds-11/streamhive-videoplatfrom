<?php
require_once __DIR__ . '/../../core/Database.php';

class CategoryModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll()
    {
        return $this->db->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByVideoId(int $videoId)
    {
        return $this->db->query("
            SELECT categories.*
            FROM categories
            JOIN video_category ON categories.id = video_category.category_id
            WHERE video_category.video_id = :video_id
        ", [':video_id' => $videoId])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addToVideo(int $videoId, int $categoryId)
    {
        return $this->db->query(
            "INSERT IGNORE INTO video_category (video_id, category_id) VALUES (:video_id, :category_id)",
            [':video_id' => $videoId, ':category_id' => $categoryId]
        );
    }
}