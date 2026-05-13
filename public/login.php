<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/../app/models/UserModel.php';

$userModel = new UserModel();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_POST);
    exit;

    $email    = $_POST['email'];
    $password = $_POST['password'];

    $user = $userModel->getByEmail($email);

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
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    <?php if ($error): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Wachtwoord" required><br>
        <button type="submit">Inloggen</button>
    </form>
    <a href="register.php">Nog geen account? Registreer hier</a>
</body>
</html>