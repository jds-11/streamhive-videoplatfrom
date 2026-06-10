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
    <title>Zoeken – StreamHive</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav>
        <div class="logo">STREAM<span>HIVE</span></div>
        <form method="GET">
            <input class="search-input" type="text" name="q" value="<?= $query ?>" placeholder="Search videos...">
        </form>
        <a href="dashboard.php" class="btn-outline">← Terug</a>
    </nav>
    <main>
        <h2 style="margin-bottom:20px;">Resultaten voor "<?= $query ?>"</h2>
        <?php if (empty($videos)): ?>
            <p style="color:#666666;">Geen videos gevonden.</p>
        <?php else: ?>
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
        <?php endif; ?>
    </main>
</body>
</html>