<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
</head>
<body>

<h1>ログイン</h1>

<?php if (!empty($_SESSION['login_error'])): ?>
    <div>
        <?= htmlspecialchars($_SESSION['login_error']) ?>
    </div>
    <?php unset($_SESSION['login_error']); ?>
<?php endif; ?>

<form action="login-process.php" method="post">

    <p>
        <a href="register.php">
            はじめての方は会員登録
        </a>
    </p>

    <p>
        <label>
            メールアドレス<br>
            <input type="email" name="email" required>
        </label>
    </p>

    <p>
        <label>
            パスワード<br>
            <input type="password" name="password" required>
        </label>
    </p>

    <button type="submit">ログイン</button>

</form>

</body>
</html>