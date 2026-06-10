<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/../app/models/UserModel.php';

$userModel = new UserModel();
$message   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $user  = $userModel->getByEmail($email);

    if ($user) {
        $token = bin2hex(random_bytes(32));
        $userModel->setResetToken($email, $token);
        $message = 'Reset link: <a href="reset_password.php?token=' . $token . '">Klik hier</a>';
    } else {
        $message = 'Email niet gevonden.';
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Wachtwoord vergeten</title>
</head>
<body>
    <h1>Wachtwoord vergeten</h1>

    <?php if ($message): ?>
        <p><?= $message ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <button type="submit">Verstuur reset link</button>
    </form>
    <a href="login.php">Terug naar login</a>
</body>
</html>