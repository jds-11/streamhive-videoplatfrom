<?php
require_once __DIR__ . '/../app/models/UserModel.php';
require_once __DIR__ . '/../app/models/VideoModel.php';

$userModel  = new UserModel();
$videoModel = new VideoModel();

// INSERT testen
$userModel->insert('jan@example.com', 'geheim123');
$videoModel->insert('Mijn eerste video', 'Een gave video', 'video1.mp4', 1);

echo "<br>";

// SELECT testen
$users  = $userModel->getAll();
$videos = $videoModel->getAll();

echo "<pre>";
print_r($users);
print_r($videos);
echo "</pre>";