<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/../app/models/UserModel.php';

$userModel = new UserModel();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $userModel->insert($email, $password);
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Registreren</title>
</head>
<body>
    <h1>Registreren</h1>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Wachtwoord" required><br>
        <button type="submit">Registreren</button>
    </form>
    <a href="login.php">Al een account? Login hier</a>
</body>
</html>