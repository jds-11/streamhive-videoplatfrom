<?php
function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /streamhive-videoplatfrom/public/login.php');
        exit;
    }
}

function requireAdmin() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header('Location: /streamhive-videoplatfrom/public/login.php');
        exit;
    }
}