<?php
global $conn;
include('config.php');


if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    die("Достъп отказан.");
}


if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    if ($id == $_SESSION['user_id']) {
        die("Не можете да изтриете себе си.");
    }


    $photos = $conn->query("SELECT filename FROM photos WHERE user_id = $id");
    while ($row = $photos->fetch_assoc()) {
        if (file_exists("uploads/" . $row['filename'])) {
            unlink("uploads/" . $row['filename']);
        }
    }


    $conn->query("DELETE FROM photos WHERE user_id = $id");
    $conn->query("DELETE FROM users WHERE id = $id");

    header("Location: admin_users.php");
    exit;
}


if (isset($_GET['make_admin'])) {
    $id = intval($_GET['make_admin']);
    $conn->query("UPDATE users SET is_admin = 1 WHERE id = $id");
    header("Location: admin_users.php");
    exit;
}


if (isset($_GET['remove_admin'])) {
    $id = intval($_GET['remove_admin']);

    if ($id == $_SESSION['user_id']) {
        die("Не можете да премахнете своите админ права.");
    }

    $conn->query("UPDATE users SET is_admin = 0 WHERE id = $id");
    header("Location: admin_users.php");
    exit;
}


$users = $conn->query("SELECT id, username, email, is_admin FROM users ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Админ Панел — Потребители</title>

    <link rel="stylesheet" href="theme.css">
    <link rel="stylesheet" href="admin.css">

</head>
<body>
<div class="admin-menu">

    <a href="gallery.php" class="admin-menu-item">Галерия</a>
    <a href="upload.php" class="admin-menu-item">Качи снимка</a>
    <a href="index.php" class="admin-menu-item">Начало</a>
    <a href="logout.php" class="admin-menu-item logout">Изход</a>
</div>

<div class="admin-container">
    <h2 class="admin-title">Админ Панел — Управление на Потребители</h2>

    <table class="admin-table">
        <tr>
            <th>ID</th>
            <th>Потребител</th>
            <th>Имейл</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>

        <?php while ($u = $users->fetch_assoc()): ?>
            <tr>
                <td><?php echo $u['id']; ?></td>

                <td><?php echo htmlspecialchars($u['username']); ?></td>

                <td><?php echo htmlspecialchars($u['email']); ?></td>

                <td>
                    <?php if ($u['is_admin']): ?>
                        <span class="role-badge role-admin">Админ</span>
                    <?php else: ?>
                        <span class="role-badge role-user">Потребител</span>
                    <?php endif; ?>
                </td>

                <td>
                    <?php if ($u['id'] == $_SESSION['user_id']): ?>
                        <span class="admin-note">(това сте вие)</span>
                    <?php else: ?>

                        <?php if ($u['is_admin']): ?>
                            <a class="admin-btn btn-remove-admin" href="admin_users.php?remove_admin=<?php echo $u['id']; ?>">
                                Махни админ
                            </a>
                        <?php else: ?>
                            <a class="admin-btn btn-make-admin" href="admin_users.php?make_admin=<?php echo $u['id']; ?>">
                                Направи админ
                            </a>
                        <?php endif; ?>

                        <a class="admin-btn btn-delete-user"
                           href="admin_users.php?delete=<?php echo $u['id']; ?>"
                           onclick="return confirm('Да изтрия ли този потребител и всички негови снимки?');">
                            Изтрий
                        </a>

                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>

    </table>

</div>

</body>
</html>