<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/../app/helpers/auth.php';
require_once __DIR__ . '/../app/models/VideoModel.php';

requireLogin();

$videoModel = new VideoModel();
$video      = $videoModel->getById($_GET['id']);
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
    <video width="640" controls>
        <source src="../../uploads/<?= $video['filename'] ?>" type="video/mp4">
    </video>
    <br>
    <a href="dashboard.php">Terug naar dashboard</a>
</body>
</html>