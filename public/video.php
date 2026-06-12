<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/../app/helpers/auth.php';
require_once __DIR__ . '/../app/models/VideoModel.php';
require_once __DIR__ . '/../app/models/CommentModel.php';
require_once __DIR__ . '/../app/models/LikeModel.php';

requireLogin();

$videoId = (int)$_GET['id'];
$userId  = $_SESSION['user_id'];

$videoModel   = new VideoModel();
$commentModel = new CommentModel();
$likeModel    = new LikeModel();

$videoModel->incrementViews($videoId);
$video = $videoModel->getById($videoId);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $commentModel->insert($videoId, $userId, $_POST['comment']);
    header('Location: video.php?id=' . $videoId);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['like'])) {
    if ($likeModel->hasLiked($videoId, $userId)) {
        $likeModel->delete($videoId, $userId);
    } else {
        $likeModel->insert($videoId, $userId);
    }
    header('Location: video.php?id=' . $videoId);
    exit;
}

$comments  = $commentModel->getByVideoId($videoId);
$likeCount = $likeModel->countByVideoId($videoId);
$hasLiked  = $likeModel->hasLiked($videoId, $userId);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title><?= $video['title'] ?> – StreamHive</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav>
        <div class="logo">STREAM<span>HIVE</span></div>
        <a href="dashboard.php" class="btn-outline">← Terug</a>
    </nav>
    <div class="video-page">
        <video controls>
            <source src="uploads/<?= $video['filename'] ?>" type="video/mp4">
        </video>
        <h1><?= $video['title'] ?></h1>
        <div class="video-meta"><?= $video['views'] ?> views</div>
        <p style="color:#F5F5F5; font-size:14px; margin-bottom:15px;"><?= $video['description'] ?></p>

        <form method="POST">
            <button type="submit" name="like" class="like-btn <?= $hasLiked ? 'liked' : '' ?>">
                <?= $hasLiked ? '👎 Unlike' : '👍 Like' ?> (<?= $likeCount ?>)
            </button>
        </form>

        <div class="comments">
            <h2>Comments</h2>
            <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <strong><?= $comment['commenter'] ?></strong>
                    <p><?= $comment['content'] ?></p>
                </div>
            <?php endforeach; ?>
            <form method="POST">
                <textarea name="comment" placeholder="Schrijf een comment..." required></textarea><br>
                <button type="submit" class="btn" style="margin-top:10px;">Plaatsen</button>
            </form>
        </div>
    </div>
</body>
</html>