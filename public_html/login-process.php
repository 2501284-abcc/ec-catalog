<?php

require_once __DIR__ . '/../includes/config.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

$genericError = 'メールアドレスまたはパスワードが違います';

$stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
$stmt->execute([$email]);

$user = $stmt->fetch();

if ($user && $password === $user['password']) {

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];

    header('Location: mypage.php');
    exit;
}

$_SESSION['login_error'] = $genericError;

header('Location: login.php');
exit;