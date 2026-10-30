<?php

require_once __DIR__ . '/../includes/config.php';

session_start();

$user = null;

if (isset($_SESSION['user_id'])) {

    $stmt = $pdo->prepare(
        'SELECT name, role FROM users WHERE id = ?'
    );

    $stmt->execute([
        $_SESSION['user_id']
    ]);

    $user = $stmt->fetch();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>マイページ</title>
</head>
<body>

<?php if ($user): ?>

    <h1>
        ようこそ、
        <?= htmlspecialchars($user['name']) ?>
        さん
    </h1>

    <p>
        会員種別：
        <?= $user['role'] === 'admin' ? '管理者' : '一般会員' ?>
    </p>

    <p>
        <a href="logout.php">ログアウト</a>
    </p>

<?php else: ?>

    <h1>ようこそ、ゲスト さん</h1>

    <p>
        <a href="login.php">ログインする</a>
    </p>

<?php endif; ?>

</body>
</html>