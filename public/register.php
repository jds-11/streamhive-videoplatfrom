<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/../app/models/UserModel.php';

$userModel = new UserModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userModel->insert($_POST['email'], $_POST['password']);
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Registreren – StreamHive</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="auth-page">
        <div class="box">
            <span class="logo">STREAM<span>HIVE</span></span>
            <form method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Wachtwoord" required>
                <button class="btn" type="submit" style="width:100%;">Registreren</button>
            </form>
            <div class="link">
                Al een account? <a href="login.php">Login hier</a>
            </div>
        </div>
    </div>
</body>
</html>