<?php global $conn;
include('config.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Галерия</title>
    <link rel="stylesheet" href="theme.css">

</head>
<body>

<div class="navbar">

    <a href="index.php">Начало</a>
    <a href="upload.php">Качи снимка</a>
    <?php if($_SESSION['is_admin']): ?>
        <a href="admin_users.php">Админ панел</a>
    <?php endif; ?>
    <a href="logout.php">Изход</a>
</div>

<div class="container">
    <h2>Галерия</h2>

    <div class="gallery">
        <?php
        $result = $conn->query("SELECT p.*, u.username FROM photos p JOIN users u ON p.user_id=u.id ORDER BY p.uploaded_at DESC");
        while ($row = $result->fetch_assoc()):
            ?>
            <div class="gallery-item">
                <img src="uploads/<?php echo $row['filename']; ?>">
                <h3><?php echo $row['title']; ?></h3>
                <p>от <?php echo $row['username']; ?></p>

                <?php if ($_SESSION['user_id'] == $row['user_id'] || $_SESSION['is_admin']): ?>
                    <a class="delete-link" href="delete.php?id=<?php echo $row['id']; ?>">Изтрий</a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
</div>

</body>
</html>