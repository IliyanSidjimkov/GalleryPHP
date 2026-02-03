<?php global $conn;
include('config.php');
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Качване</title>
    <link rel="stylesheet" href="theme.css">
</head>
<body>
<div class="navbar">
    <?php if (isset($_SESSION['username'])): ?>

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
    <h2>Качи снимка</h2>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Заглавие" required>
        <input type="file" name="photo" required>
        <button name="upload">Качи</button>
    </form>

    <?php
    if (isset($_POST['upload'])) {
        $title = $_POST['title'];
        $filename = time() . "_" . $_FILES["photo"]["name"];
        $target = "uploads/" . $filename;

        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target)) {
            $stmt = $conn->prepare("INSERT INTO photos (user_id, filename, title) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $_SESSION['user_id'], $filename, $title);
            $stmt->execute();
            echo "<p class='success'>Успешно качена!</p>";
        } else {
            echo "<p class='error'>Грешка при качване.</p>";
        }
    }
    ?>
</div>

</body>
</html>
