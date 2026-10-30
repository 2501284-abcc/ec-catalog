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

$plainMatch =
    ($user && $password === $user['password']);

$plainMatch =
    ($user && $password === $user['password']);

if (
    $user &&
    (
        password_verify(
            $password,
            $user['password']
        )
        || $plainMatch
    )
) {

    if ($plainMatch) {

        $rehash = $pdo->prepare(
            'UPDATE users
             SET password = ?
             WHERE id = ?'
        );

        $rehash->execute([
            password_hash(
                $password,
                PASSWORD_DEFAULT
            ),
            $user['id']
        ]);
    }

    $reset = $pdo->prepare(
        'UPDATE users
         SET failed_count = 0,
             locked_until = NULL
         WHERE id = ?'
    );

    $reset->execute([
        $user['id']
    ]);

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role']    = $user['role'];

    header('Location: mypage.php');
    exit;
}

$_SESSION['login_error'] = $genericError;

header('Location: login.php');
exit;