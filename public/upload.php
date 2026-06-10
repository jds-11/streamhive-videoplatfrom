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
    $file        = $_FILES['video'];
    $filename    = time() . '_' . $file['name'];
    $uploadDir   = __DIR__ . '/../../uploads/';

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
    <title>Upload – StreamHive</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav>
        <div class="logo">STREAM<span>HIVE</span></div>
        <a href="dashboard.php" class="btn-outline">← Terug</a>
    </nav>
    <div class="upload-page">
        <div class="upload-box">
            <h1>Upload Video</h1>
            <?php if ($error): ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="upload-area">
                    <div>☁️</div>
                    <p>Drag & drop your video here</p>
                    <p>or</p>
                    <label>
                        <span class="select-btn">Select File</span>
                        <input type="file" name="video" accept="video/*" required>
                    </label>
                </div>
                <label>Title</label>
                <input type="text" name="title" placeholder="Enter video title" required>
                <label>Description</label>
                <textarea name="description" placeholder="Tell your viewers about your video..." required></textarea>
                <button class="btn" type="submit" style="width:100%;">Upload</button>
            </form>
        </div>
    </div>
</body>
</html>