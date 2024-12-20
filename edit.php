<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: user_dashboard.php'); // Redirect jika bukan admin
}

require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];

    $query = "UPDATE data SET nama = :nama, deskripsi = :deskripsi WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['nama' => $nama, 'deskripsi' => $deskripsi, 'id' => $id]);

    echo "Data berhasil diperbarui.";
}

$id = $_GET['id'];
$query = "SELECT * FROM data WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $id]);
$item = $stmt->fetch();
?>

<form method="POST">
    <input type="hidden" name="id" value="<?= $item['id'] ?>">
    <input type="text" name="nama" value="<?= $item['nama'] ?>" required>
    <textarea name="deskripsi" required><?= $item['deskripsi'] ?></textarea>
    <button type="submit">Update</button>
</form>
