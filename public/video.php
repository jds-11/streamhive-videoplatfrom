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

// View teller verhogen
$videoModel->incrementViews($videoId);

$video = $videoModel->getById($videoId);

// Comment opslaan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $commentModel->insert($videoId, $userId, $_POST['comment']);
    header('Location: video.php?id=' . $videoId);
    exit;
}

// Like of unlike
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
    <title><?= $video['title'] ?></title>
</head>
<body>
    <h1><?= $video['title'] ?></h1>
    <p><?= $video['description'] ?></p>
    <p>Views: <?= $video['views'] ?></p>

    <video width="640" controls>
        <source src="../../uploads/<?= $video['filename'] ?>" type="video/mp4">
    </video>

    <br>

    <form method="POST">
        <button type="submit" name="like">
            <?= $hasLiked ? '👎 Unlike' : '👍 Like' ?> (<?= $likeCount ?>)
        </button>
    </form>

    <h2>Comments</h2>
    <?php foreach ($comments as $comment): ?>
        <p><strong><?= $comment['commenter'] ?>:</strong> <?= $comment['content'] ?></p>
    <?php endforeach; ?>

    <form method="POST">
        <textarea name="comment" placeholder="Schrijf een comment..." required></textarea><br>
        <button type="submit">Plaatsen</button>
    </form>

    <a href="dashboard.php">Terug naar dashboard</a>
</body>
</html>