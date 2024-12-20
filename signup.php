<?php
include 'db.php'; // Pastikan file db.php sudah benar dan berada di lokasi yang sesuai

// Sign Up process
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])) {
    // Sanitasi dan validasi input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Periksa apakah email atau username sudah ada di database
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Email atau Username sudah terdaftar! Silakan gunakan yang lain.');</script>";
    } else {
        // Tambahkan user baru ke database
        $stmt = $conn->prepare("INSERT INTO users (email, username, password, role) VALUES (?, ?, ?, 'user')");
        $stmt->bind_param("sss", $email, $username, $hashed_password);

        if ($stmt->execute()) {
            echo "<script>alert('Sign Up berhasil! Silakan login.'); window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat menyimpan data.');</script>";
        }
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up to Start Listening</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style3.css">
    <!-- Menambahkan Favicon -->
    <link rel="icon" href="WEB/Aset/Logo.PNG" type="image/png"> <!-- Ganti dengan path logo Anda -->
</head>
<body>
    <div class="signup-container">
        <div class="signup-box">
            <div class="header-text">
                <img src="WEB/Aset/Logo.PNG" alt="SuaraNesia Logo" class="wave-logo">
                <span class="brand-name">SuaraNesia</span>
                <h2>Sign Up to Start Listening</h2>
                <p>Temukan suara terbaik, dukung karya lokal, dan jadilah bagian dari perjalanan musik Indonesia yang semakin berkembang.</p>
            </div>
            <form action="signup.php" method="POST" class="signup-form">
                <input type="email" name="email" placeholder="name@domain.com" required>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="signup-btn">Next</button>
            </form>
            <div class="footer">
                <p>Already have an account? <a href="login.php">Log In Here</a></p>
            </div>
        </div>
    </div>
</body>
</html>
