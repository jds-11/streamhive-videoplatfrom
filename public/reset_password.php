<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/../app/models/UserModel.php';

$userModel = new UserModel();
$message   = '';
$token     = $_GET['token'] ?? '';
$user      = $userModel->getByResetToken($token);

if (!$user) {
    die('Ongeldige of verlopen reset link.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userModel->updatePassword($user['id'], $_POST['password']);
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Wachtwoord resetten</title>
</head>
<body>
    <h1>Nieuw wachtwoord instellen</h1>

    <form method="POST">
        <input type="password" name="password" placeholder="Nieuw wachtwoord" required><br>
        <button type="submit">Opslaan</button>
    </form>
</body>
</html>