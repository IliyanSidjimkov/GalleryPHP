<?php global $conn;
include('config.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Регистрация</title>

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
        <a href="login.php">Вход</a>
    <?php endif; ?>
</div>
<div class="container">
    <h2>Регистрация</h2>

    <form method="POST">
        <input type="text" name="username" placeholder="Потребителско име" required>
        <input type="email" name="email" placeholder="Имейл" required>


        <div class="password-field">
            <input type="password" id="password" name="password" placeholder="Парола" required>
            <span class="toggle-password" onclick="togglePassword('password')"></span>
        </div>


        <div class="password-field">
            <input type="password" id="password2" name="password2" placeholder="Повтори паролата" required>
            <span class="toggle-password" onclick="togglePassword('password2')"></span>
        </div>

        <button name="register">Регистрация</button>
    </form>

    <?php
    if (isset($_POST['register'])) {

        $username = $_POST['username'];
        $email = $_POST['email'];

        $password1 = $_POST['password'];
        $password2 = $_POST['password2'];


        if ($password1 !== $password2) {
            echo "<div class='error-message'>Паролите не съвпадат!</div>";
            return;
        }


        $checkEmail = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $resultEmail = $checkEmail->get_result();

        if ($resultEmail->num_rows > 0) {
            echo "<div class='error-message'>Този имейл вече е използван!</div>";
            return;
        }


        $checkUsername = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $checkUsername->bind_param("s", $username);
        $checkUsername->execute();
        $resultUsername = $checkUsername->get_result();

        if ($resultUsername->num_rows > 0) {
            echo "<div class='error-message'>Това потребителско име е заето!</div>";
            return;
        }


        $password = password_hash($password1, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, email, password, is_admin) VALUES (?, ?, ?, 0)");
        $stmt->bind_param("sss", $username, $email, $password);
        $stmt->execute();

        echo "
    <div class='success-message'>
        Регистрацията е успешна!<br>
        <a href='login.php' class='success-btn'>Вход</a>
    </div>";
    }
    ?>
</div>

</body>
</html>
