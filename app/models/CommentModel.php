<?php
require_once __DIR__ . '/../../core/Database.php';

class CommentModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getByVideoId(int $videoId)
    {
        return $this->db->query("
            SELECT comments.*, users.email as commenter
            FROM comments
            JOIN users ON comments.user_id = users.id
            WHERE comments.video_id = :video_id
        ", [':video_id' => $videoId])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(int $videoId, int $userId, string $comment)
    {
        return $this->db->query(
            "INSERT INTO comments (video_id, user_id, comment) VALUES (:video_id, :user_id, :comment)",
            [
                ':video_id' => $videoId,
                ':user_id'  => $userId,
                ':comment'  => $comment,
            ]
        );
    }
}