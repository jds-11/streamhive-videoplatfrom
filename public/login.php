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
    $user     = $userModel->getByEmail($email);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role']    = $user['role'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Verkeerd email of wachtwoord';
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Login – StreamHive</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="auth-page">
        <div class="box">
            <span class="logo">STREAM<span>HIVE</span></span>
            <?php if ($error): ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>
            <form method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Wachtwoord" required>
                <button class="btn" type="submit" style="width:100%;">Inloggen</button>
            </form>
            <div class="link">
                Nog geen account? <a href="register.php">Registreer hier</a>
            </div>
        </div>
    </div>
</body>
</html>