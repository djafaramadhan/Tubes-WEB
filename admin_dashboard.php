<?php

include 'db.php'; // Jika db.php tidak memulai session, tidak perlu session_start() di sini.
include 'header.php'; // header.php akan menangani session_start().

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah pengguna adalah admin
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Tambah pengguna baru
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = htmlspecialchars($_POST['role']);

    $stmt = $conn->prepare("INSERT INTO users (email, username, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $email, $username, $password, $role);

    if ($stmt->execute()) {
        echo "<script>alert('User berhasil ditambahkan!');</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menambahkan user.');</script>";
    }

    $stmt->close();
}

// Hapus pengguna
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user_id'])) {
    $delete_user_id = intval($_POST['delete_user_id']);

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $delete_user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Pengguna berhasil dihapus!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menghapus pengguna.');</script>";
    }

    $stmt->close();
}

//Tambah Lagu
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['song_title']) && isset($_POST['song_artist'])) {
    $song_title = htmlspecialchars($_POST['song_title']);
    $song_artist = htmlspecialchars($_POST['song_artist']);

    // Proses file audio
    if (isset($_FILES['song_audio']) && $_FILES['song_audio']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['song_audio']['tmp_name'];
        $file_name = basename($_FILES['song_audio']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_extensions = ['mp3', 'wav', 'ogg'];

        if (in_array($file_ext, $allowed_extensions)) {
            $upload_dir = "uploads/songs/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $new_file_name = uniqid() . '.' . $file_ext;
            $upload_path = $upload_dir . $new_file_name;

            if (move_uploaded_file($file_tmp, $upload_path)) {
                // Simpan informasi lagu ke database
                $stmt = $conn->prepare("INSERT INTO songs (title, artist, audio_path) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $song_title, $song_artist, $upload_path);

                if ($stmt->execute()) {
                    echo "<script>alert('Lagu berhasil ditambahkan!');</script>";
                } else {
                    echo "<script>alert('Terjadi kesalahan saat menyimpan lagu.');</script>";
                }

                $stmt->close();
            } else {
                echo "<script>alert('Gagal mengunggah file audio.');</script>";
            }
        } else {
            echo "<script>alert('Format file tidak didukung. Hanya mp3, wav, dan ogg yang diperbolehkan.');</script>";
        }
    } else {
        echo "<script>alert('Harap unggah file audio.');</script>";
    }
}

//Tambah Album
// Tambah Album
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['album_title']) && isset($_POST['album_artist'])) {
    $album_title = htmlspecialchars($_POST['album_title']);
    $album_artist = htmlspecialchars($_POST['album_artist']);

    // Proses upload gambar album
    if (isset($_FILES['album_image']) && $_FILES['album_image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['album_image']['tmp_name'];
        $file_name = basename($_FILES['album_image']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Validasi format file gambar
        if (in_array($file_ext, $allowed_extensions)) {
            $upload_dir = "uploads/albums/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);  // Membuat folder jika belum ada
            }

            $new_file_name = uniqid() . '.' . $file_ext;  // Nama file unik
            $upload_path = $upload_dir . $new_file_name;

            // Proses upload gambar
            if (move_uploaded_file($file_tmp, $upload_path)) {
                // Simpan informasi album ke database
                $stmt = $conn->prepare("INSERT INTO albums (title, artist, image_path) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $album_title, $album_artist, $upload_path);

                if ($stmt->execute()) {
                    echo "<script>alert('Album berhasil ditambahkan!');</script>";
                } else {
                    echo "<script>alert('Terjadi kesalahan saat menyimpan album.');</script>";
                }

                $stmt->close();
            } else {
                echo "<script>alert('Gagal mengunggah gambar album.');</script>";
            }
        } else {
            echo "<script>alert('Format gambar tidak valid. Hanya jpg, jpeg, png, dan gif yang diperbolehkan.');</script>";
        }
    } else {
        echo "<script>alert('Harap unggah gambar album.');</script>";
    }
}

//Tambah Artis
// Tambah Artis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['artist_name'])) {
    $artist_name = htmlspecialchars($_POST['artist_name']);

    // Proses upload gambar artis
    if (isset($_FILES['artist_image']) && $_FILES['artist_image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['artist_image']['tmp_name'];
        $file_name = basename($_FILES['artist_image']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Validasi format file gambar
        if (in_array($file_ext, $allowed_extensions)) {
            $upload_dir = "uploads/artists/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);  // Membuat folder jika belum ada
            }

            $new_file_name = uniqid() . '.' . $file_ext;  // Nama file unik
            $upload_path = $upload_dir . $new_file_name;

            // Proses upload gambar
            if (move_uploaded_file($file_tmp, $upload_path)) {
                // Simpan informasi artis ke database
                $stmt = $conn->prepare("INSERT INTO artists (name, image_path) VALUES (?, ?)");
                $stmt->bind_param("ss", $artist_name, $upload_path);

                if ($stmt->execute()) {
                    echo "<script>alert('Artis berhasil ditambahkan!');</script>";
                } else {
                    echo "<script>alert('Terjadi kesalahan saat menyimpan artis.');</script>";
                }

                $stmt->close();
            } else {
                echo "<script>alert('Gagal mengunggah gambar artis.');</script>";
            }
        } else {
            echo "<script>alert('Format gambar tidak valid. Hanya jpg, jpeg, png, dan gif yang diperbolehkan.');</script>";
        }
    } else {
        echo "<script>alert('Harap unggah gambar artis.');</script>";
    }
}


// Ambil semua data pengguna dari database
$result = $conn->query("SELECT id, email, username, role FROM users ORDER BY id DESC");
$users = $result->fetch_all(MYSQLI_ASSOC);

// Ambil semua data lagu dari database
$songs_result = $conn->query("SELECT title, artist, audio_path FROM songs ORDER BY id DESC LIMIT 6");
$songs = $songs_result->fetch_all(MYSQLI_ASSOC);

// Ambil semua data artis dari database
$artists_result = $conn->query("SELECT name, image_path FROM artists ORDER BY id DESC LIMIT 6");
$artists = $artists_result->fetch_all(MYSQLI_ASSOC);

// Ambil semua data album dari database
$albums_result = $conn->query("SELECT title, artist, image_path FROM albums ORDER BY id DESC LIMIT 6");
$albums = $albums_result->fetch_all(MYSQLI_ASSOC);


$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - SuaraNesia</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style5.css">
    <!-- Menambahkan Favicon -->
    <link rel="icon" href="WEB/Aset/Logo.PNG" type="image/png"> <!-- Ganti dengan path logo Anda -->
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo">
            <img src="WEB/Aset/Logo.PNG" alt="SuaraNesia Logo" class="wave-logo">
            <span class="brand-name">SuaraNesia</span>
        </div>
        <nav class="nav-header">
            <a href="profile.php" class="nav-link">Profile</a>
            <a href="logout.php" class="nav-link">Log Out</a>
        </nav>
    </header>
    
    <?php include 'header.php'; ?>
    <div class="admin-container">
        <h1>Admin Panel</h1>

        <!-- Daftar Pengguna -->
        <h2>Daftar Pengguna</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['role']; ?></td>
                        <td>
                            <form action="admin.php" method="POST" style="display:inline;">
                                <input type="hidden" name="delete_user_id" value="<?php echo $user['id']; ?>">
                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Form Tambah Pengguna -->
        <h2>Tambah Pengguna Baru</h2>
        <form action="admin.php" method="POST" class="add-user-form">
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit">Tambah User</button>
        </form>

        <!-- Form Tambah Lagu -->
        <h2>Tambah Lagu</h2>
        <form action="admin.php" method="POST" enctype="multipart/form-data" class="add-user-form">
            <input type="text" name="song_title" placeholder="Judul Lagu" required>
            <input type="text" name="song_artist" placeholder="Artis Lagu" required>
            <input type="file" name="song_audio" accept=".mp3, .wav, .ogg" required>
            <button type="submit">Tambah Lagu</button>
        </form>

        <!-- Form Tambah Album -->
        <h2>Tambah Album</h2>
        <form action="admin.php" method="POST" enctype="multipart/form-data" class="add-user-form">
            <input type="text" name="album_title" placeholder="Judul Album" required>
            <input type="text" name="album_artist" placeholder="Artis Album" required>
            <input type="file" name="album_image" accept="image/*" required>
            <button type="submit">Tambah Album</button>
        </form>


        <!-- Form Tambah Artis -->
        <h2>Tambah Artis</h2>
        <form action="admin.php" method="POST" enctype="multipart/form-data" class="add-user-form">
            <input type="text" name="artist_name" placeholder="Nama Artis" required>
            <input type="file" name="artist_image" accept="image/*" required>
            <button type="submit">Tambah Artis</button>
        </form>

    </div>
</body>
</html>
