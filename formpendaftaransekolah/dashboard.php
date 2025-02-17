<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

// Mengambil jumlah total pendaftar
$query_total = "SELECT COUNT(*) as total FROM siswa";
$result_total = mysqli_query($koneksi, $query_total);
$total_pendaftar = mysqli_fetch_assoc($result_total)['total'];

// Mengambil pendaftar hari ini
$query_today = "SELECT COUNT(*) as today FROM siswa WHERE DATE(tanggal_daftar) = CURDATE()";
$result_today = mysqli_query($koneksi, $query_today);
$pendaftar_hari_ini = mysqli_fetch_assoc($result_today)['today'];

// Proses Pencarian
$search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
$where = "";
if(!empty($search)) {
    $where = "WHERE nama_lengkap LIKE '%$search%' 
              OR no_pendaftaran LIKE '%$search%' 
              OR asal_sekolah LIKE '%$search%'";
}

include 'header.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SMPN 2 Pujut</title>
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
        }

        .nav-menu {
            background-color: #4CAF50;
            padding: 10px;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            margin-right: 10px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .nav-menu a:hover {
            background-color: #45a049;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }

        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .card h3 {
            color: #333;
            margin-bottom: 10px;
        }

        .card .number {
            font-size: 2em;
            color: #4CAF50;
            font-weight: bold;
        }

        .recent-registrations {
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .welcome-msg {
            background-color: white;
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .welcome-user {
            color: white;
            margin-right: 20px;
        }
        .logout-btn {
            color: white;
            text-decoration: none;
            background-color: #ff4444;
            padding: 8px 15px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .logout-btn:hover {
            background-color: #cc0000;
        }
        .nav-right {
            float: right;
            display: flex;
            align-items: center;
        }

        .search-container {
            margin: 20px 0;
            display: flex;
            gap: 10px;
        }

        .search-container input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .search-container button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .search-container button:hover {
            background-color: #45a049;
        }

        .clear-search {
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        .clear-search:hover {
            background-color: #da190b;
        }

        .no-results {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            border-radius: 4px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome-msg">
            <h2>Selamat Datang di Sistem Pendaftaran Siswa Baru</h2>
            <p>SMPN 2 Pujut - Tahun Ajaran <?php echo date('Y'); ?>/<?php echo date('Y')+1; ?></p>
        </div>

        <div class="dashboard-cards">
            <div class="card">
                <h3>Total Pendaftar</h3>
                <div class="number"><?php echo $total_pendaftar; ?></div>
                <p>Siswa</p>
            </div>
            <div class="card">
                <h3>Pendaftar Hari Ini</h3>
                <div class="number"><?php echo $pendaftar_hari_ini; ?></div>
                <p>Siswa</p>
            </div>
        </div>

        <div class="recent-registrations">
            <h2>Data Pendaftar</h2>
            
            <!-- Form Pencarian -->
            <div class="search-container">
                <form action="" method="GET" style="display: flex; gap: 10px; flex: 1;">
                    <input type="text" name="search" placeholder="Cari berdasarkan nama, nomor pendaftaran, atau asal sekolah..." 
                           value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit">Cari</button>
                    <?php if(!empty($search)): ?>
                        <a href="dashboard.php" class="clear-search">Reset</a>
                    <?php endif; ?>
                </form>
            </div>

            <table>
                <tr>
                    <th>No. Pendaftaran</th>
                    <th>Nama Lengkap</th>
                    <th>Asal Sekolah</th>
                    <th>Tanggal Daftar</th>
                </tr>
                <?php
                $query_recent = "SELECT * FROM siswa $where ORDER BY tanggal_daftar DESC LIMIT 10";
                $result_recent = mysqli_query($koneksi, $query_recent);
                if(mysqli_num_rows($result_recent) > 0):
                    while($row = mysqli_fetch_assoc($result_recent)):
                ?>
                <tr>
                    <td><?php echo $row['no_pendaftaran']; ?></td>
                    <td><?php echo $row['nama_lengkap']; ?></td>
                    <td><?php echo $row['asal_sekolah']; ?></td>
                    <td><?php echo date('d-m-Y H:i:s', strtotime($row['tanggal_daftar'])); ?></td>
                </tr>
                <?php 
                    endwhile;
                else:
                ?>
                <tr>
                    <td colspan="4" class="no-results">
                        <?php echo empty($search) ? "Belum ada data pendaftar" : "Tidak ditemukan hasil untuk pencarian: " . htmlspecialchars($search); ?>
                    </td>
                </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html> 