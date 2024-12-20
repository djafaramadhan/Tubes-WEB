<?php
session_start();
session_unset();
session_destroy();
header("Location: login.php");
exit();
?>


<!DOCTYPE html>
<html lang="en">
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
    
</body>
</html>