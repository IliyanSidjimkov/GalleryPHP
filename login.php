<?php global $conn;
include('config.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Вход</title>

    <link rel="stylesheet" href="theme.css">
</head>
<body>
<div class="navbar">
    <?php if (isset($_SESSION['username'])): ?>
        <span class ="welcome-text">
        Здравей, <b><?php echo $_SESSION['username']; ?></b> |
        </span>
        <a href="gallery.php">Галерия</a> <span class ="welcome-text">|</span>
        <a href="upload.php">Качи снимка</a> <span class ="welcome-text">|</span>
        <?php if($_SESSION['is_admin']): ?>
            <a href="admin_users.php">Админ панел</a> <span class ="welcome-text">|</span>
        <?php endif; ?>
        <a href="logout.php">Изход</a>
    <?php else: ?>
        <a href="index.php">Начало</a> <span class ="welcome-text">|</span>
        <a href="register.php">Регистрация</a>
    <?php endif; ?>
</div>
<div class="container">
    <h2>Вход</h2>

    <form method="POST">
        <input type="text" name="username" placeholder="Потребителско име" required>
        <input type="password" name="password" placeholder="Парола" required>
        <button name="login">Вход</button>
    </form>

    <?php
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = $user['is_admin'];

            header("Location: index.php");
        } else {
            echo "<p class='error'>Грешни данни!</p>";
        }
    }
    ?>
</div>

</body>
</html>