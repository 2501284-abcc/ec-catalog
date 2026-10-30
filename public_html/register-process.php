<?php

require_once __DIR__ . '/../includes/config.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

$name     = trim($_POST['name'] ?? '');
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm  = $_POST['password_confirm'] ?? '';

$errors = [];

// 必須チェック
if ($name === '') {
    $errors['name'] = '氏名を入力してください';
}

if ($email === '') {
    $errors['email'] = 'メールアドレスを入力してください';
}

if ($password === '') {
    $errors['password'] = 'パスワードを入力してください';
}

// メール形式チェック
if (
    $email !== '' &&
    filter_var($email, FILTER_VALIDATE_EMAIL) === false
) {
    $errors['email'] = 'メールアドレスの形式が正しくありません';
}

// パスワード8文字以上
if ($password !== '' && mb_strlen($password) < 8) {
    $errors['password']
        = 'パスワードは8文字以上で入力してください';
}

// パスワード確認一致
if ($password !== $confirm) {
    $errors['password_confirm']
        = 'パスワード（確認）が一致しません';
}

// メール重複チェック
if (!$errors) {

    $stmt = $pdo->prepare(
        'SELECT id FROM users WHERE email = ?'
    );

    $stmt->execute([$email]);

    if ($stmt->fetch()) {
        $errors['email']
            = 'このメールアドレスは既に登録されています';
    }
}

// エラーがあれば戻す
if ($errors) {
    $_SESSION['register_errors'] = $errors;

    $_SESSION['register_old'] = [
        'name' => $name,
        'email' => $email
    ];

    header('Location: register.php');
    exit;
}

// 登録
$hash = password_hash(
    $password,
    PASSWORD_DEFAULT
);

$stmt = $pdo->prepare(
    'INSERT INTO users (email, password, name)
     VALUES (?, ?, ?)'
);

$stmt->execute([
    $email,
    $hash,
    $name
]);

header('Location: register-done.php');
exit;