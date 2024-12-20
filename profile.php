<?php
session_start();
include 'db.php'; // Pastikan file db.php sudah benar dan koneksi berhasil

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Pastikan user_id ada dalam session
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('User ID tidak ditemukan!');</script>";
    exit();
}

// Ambil data user berdasarkan session
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id']; // Ambil user_id dari session

// Jika request method adalah POST dan data email dan username ada
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['username'])) {
    $new_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Sanitasi email
    $new_username = htmlspecialchars($_POST['username']); // Sanitasi username

    // Validasi email
    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Format email tidak valid!');</script>";
        exit();
    }

    // Update data user di database
    $stmt = $conn->prepare("UPDATE users SET email = ?, username = ? WHERE id = ?");
    if ($stmt === false) {
        die("Error preparing query: " . $conn->error);  // Menampilkan pesan error database
    }

    // Bind parameter dan eksekusi query
    $stmt->bind_param("ssi", $new_email, $new_username, $user_id);

    if ($stmt->execute()) {
        // Update session username jika update berhasil
        $_SESSION['username'] = $new_username;
        echo "<script>alert('Profil berhasil diperbarui!');</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat memperbarui profil: " . $stmt->error . "');</script>";
    }

    // Menutup statement untuk menghindari kebocoran memori
    $stmt->close();
}

// Ambil data user dari database
$stmt = $conn->prepare("SELECT email, username FROM users WHERE id = ?"); // Menggunakan user_id untuk memastikan data yang tepat
$stmt->bind_param("i", $user_id); // Menggunakan parameter integer untuk id
$stmt->execute();
$result = $stmt->get_result();

// Cek apakah data ditemukan
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    // Jika tidak ada data ditemukan, beri pesan error dan redirect atau beri nilai default
    echo "<script>alert('Data pengguna tidak ditemukan!');</script>";
    header("Location: logout.php"); // Redirect jika data tidak ditemukan
    exit();
}

$stmt->close();
$conn->close();
?>




<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - SuaraNesia</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style6.css">
    <!-- Menambahkan Favicon -->
    <link rel="icon" href="WEB/Aset/Logo.PNG" type="image/png">
</head>
<body>
    <div class="profile-container">
        <div class="profile-box">
            <div class="header-text">
                <img src="WEB/Aset/Logo.PNG" alt="SuaraNesia Logo" class="suara-logo">
                <h2>Edit Your Profile</h2>
                <p>Perbarui informasi profil Anda untuk pengalaman terbaik di SuaraNesia.</p>
            </div>
            <form action="profile.php" method="POST" class="profile-form">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" value="<?php echo $user ? htmlspecialchars($user['email']) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" value="<?php echo $user ? htmlspecialchars($user['username']) : ''; ?>" required>
                </div>
                <button type="submit" class="profile-btn">Update Profile</button>
            </form>
        </div>
    </div>
</body>
</html>
