<?php include('config.php'); ?>
    <!DOCTYPE html>
    <html>
<head>
    <title>Начало</title>

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
        <a href="login.php">Вход</a> <span class ="welcome-text">|</span>
        <a href="register.php">Регистрация</a>
    <?php endif; ?>
</div>

<div class="container">
    <h2>Добре дошли във Фото Галерия</h2>
    <p class = "home-subtitle">Това е вашето пространство за качване на снимки.</p>
</div>

</body>
    </html><?php
