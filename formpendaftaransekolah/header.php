<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect ke login jika belum login
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Cek status pendaftaran untuk user biasa
$is_registered = false;
if($_SESSION['role'] == 'user') {
    $user_id = $_SESSION['user_id'];
    $query_check = "SELECT id FROM siswa WHERE user_id = '$user_id'";
    $result_check = mysqli_query($koneksi, $query_check);
    $is_registered = mysqli_num_rows($result_check) > 0;

    // Redirect dari form pendaftaran jika sudah terdaftar
    if($is_registered && basename($_SERVER['PHP_SELF']) == 'form_pendaftaran.php') {
        header("Location: user_dashboard.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMPN 2 Pujut</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .navbar {
            background-color: #333;
            padding: 15px;
            color: white;
        }

        .navbar h1 {
            margin-bottom: 10px;
            text-align: center;
            font-size: 24px;
        }

        .nav-menu {
            background-color: #4CAF50;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 5px;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            margin-right: 5px;
            border-radius: 3px;
            transition: background-color 0.3s;
            font-size: 14px;
        }

        .nav-menu a:hover,
        .nav-menu a.active {
            background-color: #45a049;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .welcome-user {
            color: white;
            font-size: 14px;
        }

        .logout-btn {
            color: white;
            text-decoration: none;
            background-color: #dc3545;
            padding: 8px 15px;
            border-radius: 3px;
            transition: background-color 0.3s;
            font-size: 14px;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>SMPN 2 PUJUT</h1>
        <div class="nav-menu">
            <?php if($_SESSION['role'] == 'admin'): ?>
                <div>
                    <a href="dashboard.php" <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'class="active"' : ''; ?>>Dashboard</a>
                    <a href="daftar_admin.php" <?php echo basename($_SERVER['PHP_SELF']) == 'daftar_admin.php' ? 'class="active"' : ''; ?>>Daftar Admin</a>
                    <a href="lihat_pendaftar.php" <?php echo basename($_SERVER['PHP_SELF']) == 'lihat_pendaftar.php' ? 'class="active"' : ''; ?>>Data Pendaftar</a>
                </div>
            <?php else: ?>
                <div>
                    <a href="user_dashboard.php" <?php echo basename($_SERVER['PHP_SELF']) == 'user_dashboard.php' ? 'class="active"' : ''; ?>>Dashboard Saya</a>
                    <?php if(!$is_registered): ?>
                    <a href="form_pendaftaran.php" <?php echo basename($_SERVER['PHP_SELF']) == 'form_pendaftaran.php' ? 'class="active"' : ''; ?>>Form Pendaftaran</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="nav-right">
                <span class="welcome-user">Selamat datang, <?php echo $_SESSION['nama_lengkap']; ?></span>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </div>
</body>
</html> 