<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav>
    <ul class="navbar">
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
            <!-- Jika user login -->
            <li><a href="profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <!-- Jika user belum login -->
            <li><a href="signup.php">Sign Up</a></li>
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>
