<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/../app/helpers/auth.php';
require_once __DIR__ . '/../app/models/UserModel.php';
require_once __DIR__ . '/../app/models/VideoModel.php';

requireLogin();

$userModel   = new UserModel();
$videoModel  = new VideoModel();
$currentUser = $userModel->getById($_SESSION['user_id']);
$videos      = $videoModel->getAllWithUser();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>StreamHive</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav>
        <div class="logo">STREAM<span>HIVE</span></div>
        <form method="GET" action="search.php">
            <input class="search-input" type="text" name="q" placeholder="Search videos...">
        </form>
        <div style="display:flex; gap:10px;">
            <a href="upload.php" class="btn">+ Upload</a>
            <a href="logout.php" class="btn-outline">Uitloggen</a>
        </div>
    </nav>
    <main>
        <h2 style="margin-bottom:20px;">Recommended</h2>
        <div class="grid">
            <?php foreach ($videos as $video): ?>
                <a href="video.php?id=<?= $video['id'] ?>" class="card">
                    <div class="card-thumb">▶</div>
                    <div class="card-body">
                        <div class="card-title"><?= $video['title'] ?></div>
                        <div class="card-meta"><?= $video['uploader'] ?> · <?= $video['views'] ?> views</div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>