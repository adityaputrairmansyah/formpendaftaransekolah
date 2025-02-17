<?php
session_start();

// Jika sudah login, arahkan sesuai role
if(isset($_SESSION['user_id'])) {
    if($_SESSION['role'] == 'admin') {
        header("Location: dashboard.php");
    } else {
        header("Location: user_dashboard.php");
    }
    exit();
}

// Jika belum login, arahkan ke halaman login
header("Location: login.php");
exit();
?> 