<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/../app/helpers/auth.php';
require_once __DIR__ . '/../app/models/VideoModel.php';

requireLogin();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = $_POST['title'];
    $description = $_POST['description'];
    $userId      = $_SESSION['user_id'];

    $file      = $_FILES['video'];
    $filename  = time() . '_' . $file['name'];
    $uploadDir = __DIR__ . '/../../uploads/';

    if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
        $videoModel = new VideoModel();
        $videoModel->insert($title, $description, $filename, $userId);
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Upload mislukt';
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Video uploaden</title>
</head>
<body>
    <h1>Video uploaden</h1>

    <?php if ($error): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Titel" required><br>
        <textarea name="description" placeholder="Beschrijving" required></textarea><br>
        <input type="file" name="video" accept="video/*" required><br>
        <button type="submit">Uploaden</button>
    </form>
    <a href="dashboard.php">Terug naar dashboard</a>
</body>
</html>