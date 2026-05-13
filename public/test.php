<?php
require_once __DIR__ . '/../app/models/UserModel.php';
require_once __DIR__ . '/../app/models/VideoModel.php';

$userModel  = new UserModel();
$videoModel = new VideoModel();

// INSERT
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userModel->insert($_POST['email'], $_POST['password']);
}

// SELECT
$users  = $userModel->getAll();
$videos = $videoModel->getAll();
?>
<!DOCTYPE html>
<html>
<body>

    <h2>User toevoegen</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Wachtwoord" required>
        <button type="submit">Toevoegen</button>
    </form>

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