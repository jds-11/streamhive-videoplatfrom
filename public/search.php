<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/../app/helpers/auth.php';
require_once __DIR__ . '/../app/models/VideoModel.php';

requireLogin();

$videoModel = new VideoModel();
$videos     = [];
$query      = '';

if (isset($_GET['q']) && $_GET['q'] !== '') {
    $query  = $_GET['q'];
    $videos = $videoModel->search($query);
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Zoeken</title>
</head>
<body>
    <h1>Zoeken</h1>

    <form method="GET">
        <input type="text" name="q" value="<?= $query ?>" placeholder="Zoek een video..." required>
        <button type="submit">Zoeken</button>
    </form>

    <h2>Resultaten</h2>
    <?php if (empty($videos)): ?>
        <p>Geen videos gevonden.</p>
    <?php else: ?>
        <?php foreach ($videos as $video): ?>
            <div>
                <h3><a href="video.php?id=<?= $video['id'] ?>"><?= $video['title'] ?></a></h3>
                <p><?= $video['description'] ?></p>
                <p>Geüpload door: <?= $video['uploader'] ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <a href="dashboard.php">Terug naar dashboard</a>
</body>
</html>