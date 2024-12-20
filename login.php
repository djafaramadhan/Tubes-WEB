<?php
session_start(); // Mulai session di awal halaman, hanya sekali

include 'db.php'; // Pastikan file db.php sudah benar dan koneksi berhasil

// LOGIN PROCESS
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    $input = htmlspecialchars($_POST['username']); // Bisa berupa username atau email
    $password = $_POST['password'];

    // Gunakan Prepared Statement untuk mencari user berdasarkan username atau email
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $input, $input);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika data ditemukan
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Set session untuk login
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $user['username']; // Username diset di session
            $_SESSION['user_id'] = $user['id']; // ID pengguna diset di session
            $_SESSION['role'] = $user['role']; // Role diset di session

            // Redirect ke dashboard yang sesuai berdasarkan role
            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php");
                exit();
            } else {
                header("Location: user_dashboard.php");
                exit();
            }
        } else {
            // Password salah
            echo "<script>alert('Password salah!');</script>";
        }
    } else {
        // User tidak ditemukan
        echo "<script>alert('User tidak ditemukan!');</script>";
    }

    $stmt->close(); // Menutup prepared statement
    $conn->close(); // Menutup koneksi database
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to SuaraNesia</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style2.css">
    <!-- Menambahkan Favicon -->
    <link rel="icon" href="WEB/Aset/Logo.PNG" type="image/png"> <!-- Ganti dengan path logo Anda -->
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="header-text">
                <img src="WEB/Aset/Logo.PNG" alt="SuaraNesia Logo" class="suara-logo">
                <span class="brand-name">SuaraNesia</span>
                <h2>Login to SuaraNesia</h2>
                <p>Mari dengarkan, jelajahi, dan nikmati musik terbaik hanya di SuaraNesia.</p>
            </div>
            <form action="login.php" method="POST" class="login-form">
                <input type="text" name="username" placeholder="Username or Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <a href="#">Forgot your password?</a>
                <button type="submit" class="login-btn">Login</button>
                <div class="footer">
                <p>Don’t have an account? <a href="signup.php">Sign Up for SuaraNesia</a></p>
            </div>
            </form>
           
        </div>
    </div>
</body>
</html>
