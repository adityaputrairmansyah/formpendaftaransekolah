<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

// Ambil data user
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($koneksi, $query);
$user_data = mysqli_fetch_assoc($result);

// Ambil data pendaftaran user jika ada
$query_pendaftaran = "SELECT * FROM siswa WHERE user_id = '$user_id'";
$result_pendaftaran = mysqli_query($koneksi, $query_pendaftaran);
$pendaftaran = mysqli_fetch_assoc($result_pendaftaran);

include 'header.php';
?>

<style>
    .container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 20px;
    }

    .welcome-banner {
        background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        color: white;
        padding: 30px;
        border-radius: 10px;
        margin-bottom: 30px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .welcome-banner h2 {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .dashboard-card {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .card-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .card-icon {
        width: 40px;
        height: 40px;
        background: #4CAF50;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }

    .card-icon i {
        color: white;
        font-size: 20px;
    }

    .card-title {
        color: #333;
        font-size: 18px;
        font-weight: bold;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        color: #666;
        font-weight: 500;
    }

    .info-value {
        color: #333;
        font-weight: 600;
    }

    .status-badge {
        display: inline-block;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: bold;
    }

    .status-registered {
        background-color: #4CAF50;
        color: white;
    }

    .status-pending {
        background-color: #ffd700;
        color: #333;
    }

    .action-btn {
        display: inline-block;
        padding: 12px 25px;
        background: #4CAF50;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        margin-top: 20px;
        text-align: center;
        transition: background-color 0.3s;
    }

    .action-btn:hover {
        background: #45a049;
    }

    .print-btn {
        background: #2196F3;
    }

    .print-btn:hover {
        background: #1976D2;
    }
</style>

<!-- Link Font Awesome untuk ikon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<div class="container">
    <div class="welcome-banner">
        <h2>Selamat Datang, <?php echo $_SESSION['nama_lengkap']; ?>!</h2>
        <p>SMPN 2 Pujut - Tahun Ajaran <?php echo date('Y'); ?>/<?php echo date('Y')+1; ?></p>
    </div>

    <div class="dashboard-grid">
        <!-- Informasi Akun -->
        <div class="dashboard-card">
            <div class="card-header">
                <div class="card-icon">
                    <i class="fas fa-user"></i>
                </div>
                <h3 class="card-title">Informasi Akun</h3>
            </div>
            <div class="info-item">
                <span class="info-label">Username</span>
                <span class="info-value"><?php echo $user_data['username']; ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Email</span>
                <span class="info-value"><?php echo $user_data['email']; ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Terdaftar Sejak</span>
                <span class="info-value"><?php echo date('d M Y', strtotime($user_data['created_at'])); ?></span>
            </div>
        </div>

        <!-- Status Pendaftaran -->
        <div class="dashboard-card">
            <div class="card-header">
                <div class="card-icon">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <h3 class="card-title">Status Pendaftaran</h3>
            </div>
            <?php if($pendaftaran): ?>
                <div class="info-item">
                    <span class="info-label">No. Pendaftaran</span>
                    <span class="info-value"><?php echo $pendaftaran['no_pendaftaran']; ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status</span>
                    <span class="status-badge status-registered">Terdaftar</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal Daftar</span>
                    <span class="info-value"><?php echo date('d M Y', strtotime($pendaftaran['tanggal_daftar'])); ?></span>
                </div>
                <a href="cetak_kartu.php" class="action-btn print-btn">
                    <i class="fas fa-print"></i> Cetak Kartu Peserta
                </a>
            <?php else: ?>
                <div class="info-item">
                    <span class="info-label">Status</span>
                    <span class="status-badge status-pending">Belum Daftar</span>
                </div>
                <p style="margin: 20px 0; color: #666;">Anda belum melakukan pendaftaran. Silakan daftar sekarang.</p>
                <a href="form_pendaftaran.php" class="action-btn">
                    <i class="fas fa-edit"></i> Daftar Sekarang
                </a>
            <?php endif; ?>
        </div>
    </div>

    <?php if($pendaftaran): ?>
    <!-- Detail Pendaftaran -->
    <div class="dashboard-card">
        <div class="card-header">
            <div class="card-icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <h3 class="card-title">Detail Pendaftaran</h3>
        </div>
        <div class="info-item">
            <span class="info-label">Nama Lengkap</span>
            <span class="info-value"><?php echo $pendaftaran['nama_lengkap']; ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Tempat, Tanggal Lahir</span>
            <span class="info-value"><?php echo $pendaftaran['tempat_lahir'] . ', ' . date('d M Y', strtotime($pendaftaran['tanggal_lahir'])); ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Jenis Kelamin</span>
            <span class="info-value"><?php echo $pendaftaran['jenis_kelamin']; ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Agama</span>
            <span class="info-value"><?php echo $pendaftaran['agama']; ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Asal Sekolah</span>
            <span class="info-value"><?php echo $pendaftaran['asal_sekolah']; ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Nilai UN</span>
            <span class="info-value"><?php echo $pendaftaran['nilai_un']; ?></span>
        </div>
    </div>
    <?php endif; ?>
</div>
</body>
</html> 