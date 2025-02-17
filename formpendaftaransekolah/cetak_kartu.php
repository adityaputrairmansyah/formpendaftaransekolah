<?php
session_start();
require 'koneksi.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil data pendaftaran
$user_id = $_SESSION['user_id'];
$query = "SELECT s.*, u.email 
          FROM siswa s 
          JOIN users u ON s.user_id = u.id 
          WHERE s.user_id = '$user_id'";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);

if(!$data) {
    header("Location: user_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Peserta - <?php echo $data['nama_lengkap']; ?></title>
    <style>
        @media print {
            body {
                width: 21cm;
                height: 29.7cm;
                margin: 0;
                padding: 20px;
            }
            .no-print {
                display: none;
            }
        }

        .kartu-container {
            width: 800px;
            margin: 20px auto;
            padding: 20px;
        }

        .kartu {
            border: 2px solid #000;
            padding: 20px;
            margin-bottom: 20px;
            background: #fff;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .logo {
            width: 80px;
            height: auto;
            margin-bottom: 10px;
        }

        .school-name {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }

        .card-title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }

        .info-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .info-group {
            margin-bottom: 15px;
        }

        .info-label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .info-value {
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
        }

        .ttd-box {
            margin-top: 80px;
        }

        .btn-print {
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .btn-print:hover {
            background: #45a049;
        }

        .photo-box {
            border: 1px solid #000;
            width: 3cm;
            height: 4cm;
            margin: 10px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .qr-code {
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="kartu-container">
        <button onclick="window.print()" class="btn-print no-print">Cetak Kartu</button>
        
        <div class="kartu">
            <div class="header">
                <img src="logo.png" alt="Logo Sekolah" class="logo">
                <div class="school-name">SMPN 2 PUJUT</div>
                <div>Jl. Raya Sengkol, Kec. Pujut, Lombok Tengah</div>
                <div>Telp: (0370) 123456</div>
            </div>

            <div class="card-title">KARTU PESERTA<br>PENERIMAAN SISWA BARU<br>TAHUN AJARAN <?php echo date('Y'); ?>/<?php echo date('Y')+1; ?></div>

            <div class="info-container">
                <div class="left-info">
                    <div class="info-group">
                        <div class="info-label">No. Pendaftaran</div>
                        <div class="info-value"><?php echo $data['no_pendaftaran']; ?></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Nama Lengkap</div>
                        <div class="info-value"><?php echo $data['nama_lengkap']; ?></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Tempat, Tanggal Lahir</div>
                        <div class="info-value">
                            <?php echo $data['tempat_lahir'] . ', ' . date('d-m-Y', strtotime($data['tanggal_lahir'])); ?>
                        </div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Jenis Kelamin</div>
                        <div class="info-value"><?php echo $data['jenis_kelamin']; ?></div>
                    </div>
                </div>

                <div class="right-info">
                    <div class="photo-box">
                        3x4 cm
                    </div>
                    <div class="info-group">
                        <div class="info-label">Asal Sekolah</div>
                        <div class="info-value"><?php echo $data['asal_sekolah']; ?></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Tanggal Daftar</div>
                        <div class="info-value"><?php echo date('d-m-Y', strtotime($data['tanggal_daftar'])); ?></div>
                    </div>
                </div>
            </div>

            <div class="footer">
                <div>Pujut, <?php echo date('d-m-Y'); ?></div>
                <div>Kepala Sekolah</div>
                <div class="ttd-box">
                    <div>(_______________________)</div>
                    <div>NIP.</div>
                </div>
            </div>
        </div>

        <div class="kartu">
            <div style="text-align: center; font-weight: bold; margin-bottom: 20px;">
                KETENTUAN PESERTA
            </div>
            <ol>
                <li>Kartu ini wajib dibawa saat mengikuti setiap tahapan seleksi</li>
                <li>Peserta wajib hadir 30 menit sebelum seleksi dimulai</li>
                <li>Peserta wajib berpakaian rapi dan sopan</li>
                <li>Peserta wajib mengikuti seluruh tahapan seleksi</li>
                <li>Keputusan panitia bersifat mutlak dan tidak dapat diganggu gugat</li>
            </ol>
        </div>
    </div>
</body>
</html> 