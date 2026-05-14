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
$users       = $userModel->getAll();
$videos      = $videoModel->getAll();
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
    <a href="logout.php">Uitloggen</a>
    <h2>Users</h2>
    <?php foreach ($users as $user): ?>
        <p><?= $user['email'] ?> — <?= $user['role'] ?></p>
    <?php endforeach; ?>
    <h2>Videos</h2>
    <?php foreach ($videos as $video): ?>
        <div>
            <h3><?= $video['title'] ?></h3>
            <p><?= $video['description'] ?></p>
        </div>
    <?php endforeach; ?>
</body>
</html>