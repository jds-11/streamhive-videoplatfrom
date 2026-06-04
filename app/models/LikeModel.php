<?php
require_once __DIR__ . '/../../core/Database.php';

class LikeModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function countByVideoId(int $videoId)
    {
        return $this->db->query(
            "SELECT COUNT(*) as total FROM likes WHERE video_id = :video_id",
            [':video_id' => $videoId]
        )->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function hasLiked(int $videoId, int $userId)
    {
        $result = $this->db->query(
            "SELECT id FROM likes WHERE video_id = :video_id AND user_id = :user_id",
            [':video_id' => $videoId, ':user_id' => $userId]
        )->fetch(PDO::FETCH_ASSOC);
        return $result ? true : false;
    }

    public function insert(int $videoId, int $userId)
    {
        return $this->db->query(
            "INSERT IGNORE INTO likes (video_id, user_id) VALUES (:video_id, :user_id)",
            [':video_id' => $videoId, ':user_id' => $userId]
        );
    }

    public function delete(int $videoId, int $userId)
    {
        return $this->db->query(
            "DELETE FROM likes WHERE video_id = :video_id AND user_id = :user_id",
            [':video_id' => $videoId, ':user_id' => $userId]
        );
    }
}