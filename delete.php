<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: user_dashboard.php'); // Redirect jika bukan admin
}

require 'koneksi.php';

$id = $_GET['id'];

$query = "DELETE FROM data WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $id]);

header('Location: admin_dashboard.php'); // Redirect setelah menghapus
?>
