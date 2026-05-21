<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/../app/helpers/auth.php';
require_once __DIR__ . '/../app/models/UserModel.php';
require_once __DIR__ . '/../app/models/VideoModel.php';

requireLogin();

$userModel  = new UserModel();
$videoModel = new VideoModel();
$currentUser = $userModel->getById($_SESSION['user_id']);
$videos      = $videoModel->getAllWithUser();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welkom <?= $currentUser['email'] ?>!</h1>
    <p>Rol: <?= $currentUser['role'] ?></p>
    <a href="upload.php"><button>Video uploaden</button></a>
    <a href="logout.php">Uitloggen</a>

    <h2>Videos</h2>
    <?php foreach ($videos as $video): ?>
        <div>
            <h3><a href="video.php?id=<?= $video['id'] ?>"><?= $video['title'] ?></a></h3>
            <p><?= $video['description'] ?></p>
            <p>Geüpload door: <?= $video['uploader'] ?></p>
        </div>
    <?php endforeach; ?>
</body>
</html>