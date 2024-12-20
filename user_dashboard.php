<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

include 'db.php'; // Koneksi ke database

// Ambil lagu dari database
$songs_query = "SELECT * FROM songs ORDER BY id DESC LIMIT 5"; // Ambil 5 lagu terakhir
$songs_result = $conn->query($songs_query);

// Ambil album dari database
$albums_query = "SELECT * FROM albums ORDER BY id DESC LIMIT 5"; // Ambil 5 album terakhir
$albums_result = $conn->query($albums_query);

// Ambil artis dari database
$artists_query = "SELECT * FROM artists ORDER BY id DESC LIMIT 6"; // Ambil 6 artis terakhir
$artists_result = $conn->query($artists_query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuaraNesia</title>
    <!-- Fonts & Stylesheets -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <!-- Menambahkan Favicon -->
    <link rel="icon" href="WEB/Aset/Logo.PNG" type="image/png">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo">
            <img src="WEB/Aset/Logo.PNG" alt="SuaraNesia Logo" class="wave-logo">
            <span class="brand-name">SuaraNesia</span>
        </div>
        <nav class="nav-header">
            <a href="logout.php" class="nav-link">Log Out</a>
            <a href="profile.php" class="nav-link">Profile</a>
        </nav>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <a href="#" class="menu-item active">
            <img src="WEB/Aset/Home.png" alt="Home">
            <span>Beranda</span>
        </a>
        <a href="explore.html" class="menu-item">
            <img src="WEB/Aset/Explore.png" alt="Eksplorasi">
            <span>Eksplorasi</span>
        </a>
        <a href="#" class="menu-item">
            <img src="WEB/Aset/Koleksi.png" alt="Koleksi">
            <span>Koleksi</span>
        </a>
    </aside>

    <!-- Main Content -->
    <main class="content">
        <!-- Slideshow Gambar -->
        <div class="slideshow-container">
            <img id="slideshow" src="WEB/1723094678-1200x675.webp" alt="Slideshow" class="full-width-image"/>
        </div>

        <!-- Search Bar -->
        <div class="search-bar">
            <input type="text" placeholder="Telusuri Lagu, Artis, Album">
            <button class="search-btn">🔍</button>
        </div>

        <!-- Lagu Paling Hits -->
        <div class="songs">
            <?php
            // Loop untuk menampilkan lagu dari database
            while ($song = $songs_result->fetch_assoc()) {
                // Mengambil data lagu
                $song_title = $song['title'];         // Judul lagu
                $song_artist = $song['artist'];       // Nama artis
                $song_audio_path = $song['audio_path']; // Path audio

                // Menampilkan lagu
                echo '
                <div class="song-item" data-audio="' . $song_audio_path . '">
                    <strong>' . $song_title . '</strong><br>' . $song_artist . '
                </div>';
            }
            ?>
        </div>

        <!-- Pemutar Audio -->
        <audio id="audioPlayer" controls>
            <source id="audioSource" src="" type="audio/mp3">
            Your browser does not support the audio element.
        </audio>

        <!-- Artis Paling Hits -->
        <section class="hits-artis">
            <div class="section-header">
                <h2>ARTIS PALING HITS PALING ENAK</h2>
                <a href="#" class="show-all">Show All</a>
            </div>
            <div class="artists">
                <?php
                // Loop untuk menampilkan artis dari database
                while ($artist = $artists_result->fetch_assoc()) {
                    echo '
                    <div class="artist-item">
                        <img src="' . $artist['image_path'] . '" alt="' . $artist['name'] . '">
                        <span>' . $artist['name'] . '</span>
                    </div>';
                }
                ?>
            </div>
        </section>

        <!-- Album Paling Hits -->
        <section class="hits-album">
            <div class="section-header">
                <h2>ALBUM PALING HITS PALING ENAK</h2>
                <a href="#" class="show-all">Show All</a>
            </div>
            <div class="albums">
                <?php
                // Loop untuk menampilkan album dari database
                while ($album = $albums_result->fetch_assoc()) {
                    echo '
                    <div class="album-item">
                        <img src="' . $album['image_path'] . '" alt="' . $album['title'] . '">
                        <div>
                            <strong>' . $album['title'] . '</strong><br>' . $album['artist'] . '
                        </div>
                    </div>';
                }
                ?>
            </div>
        </section>
    </main>

    <script>
    // JavaScript untuk memutar lagu ketika item lagu diklik
    document.querySelectorAll('.song-item').forEach(item => {
        item.addEventListener('click', function() {
            const audioPath = item.getAttribute('data-audio');
            const audioPlayer = document.getElementById('audioPlayer');
            const audioSource = document.getElementById('audioSource');
            
            // Mengubah sumber audio dan memulai pemutaran
            audioSource.src = audioPath;
            audioPlayer.load();  // Memuat ulang audio player
            audioPlayer.play();  // Memulai pemutaran
        });
    });
    </script>
</body>
</html>
