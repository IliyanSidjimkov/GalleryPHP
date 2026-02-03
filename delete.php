<?php
global $conn;
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT filename FROM photos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$file = $res->fetch_assoc();

unlink("uploads/" . $file['filename']);

$stmt = $conn->prepare("DELETE FROM photos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: gallery.php");
?>