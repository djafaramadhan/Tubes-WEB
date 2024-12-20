<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}
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
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                <a href="logout.php" class="nav-link">Logout</a>
                <a href="profile.php" class="nav-link">Profile</a>
            <?php else: ?>
                <a href="signup.php" class="nav-link">Sign Up</a>
                <a href="login.php" class="nav-link">Login</a>
            <?php endif; ?>
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
        <!-- Background Image -->
        <div class="background-img">
            <img src="WEB/1723094678-1200x675.webp" alt="Background Music">
        </div>

        <!-- Search Bar -->
        <div class="search-bar">
            <input type="text" placeholder="Telusuri Lagu, Artis, Album">
            <button class="search-btn">🔍</button>
        </div>

        <!-- Lagu Paling Hits -->
        <section class="hits">
            <div class="section-header">
                <h2>LAGU PALING HITS PALING ENAK</h2>
                <a href="#" class="show-all">Show All</a>
            </div>
            <div class="songs">
                <div class="song-item"><strong>Satu Bulan</strong><br>Bernadya</div>
                <div class="song-item"><strong>HAHAHA</strong><br>Juicy Luicy</div>
                <div class="song-item"><strong>Gadis Sampul</strong><br>HIVI!</div>
                <div class="song-item"><strong>Ingkar</strong><br>Tulus</div>
                <div class="song-item"><strong>Melawan Restu</strong><br>Mahalini</div>
                <div class="song-item"><strong>Gemitang Hatiku</strong><br>Lyodra</div>
            </div>
        </section>

        <!-- Artis Paling Hits -->
        <section class="hits-artis">
            <div class="section-header">
                <h2>ARTIS PALING HITS PALING ENAK</h2>
                <a href="#" class="show-all">Show All</a>
            </div>
            <div class="artists">
                <div class="artist-item"><img src="WEB/HIVI!.jpeg" alt="HIVI!"><span>HIVI!</span></div>
                <div class="artist-item"><img src="WEB/Feby Putri.jpg" alt="Feby Putri"><span>Feby Putri</span></div>
                <div class="artist-item"><img src="WEB/Juicy Luicy.jpg" alt="Juicy Luicy"><span>Juicy Luicy</span></div>
                <div class="artist-item"><img src="WEB/IMG_20240926_110437.webp" alt="Bernadya"><span>Bernadya</span></div>
                <div class="artist-item"><img src="WEB/Lyodra.jpg" alt="Lyodra"><span>Lyodra</span></div>
                <div class="artist-item"><img src="WEB/Hindia Poster Band.jpg" alt="Hindia"><span>Hindia</span></div>
            </div>
        </section>
    </main>
</body>
</html>
