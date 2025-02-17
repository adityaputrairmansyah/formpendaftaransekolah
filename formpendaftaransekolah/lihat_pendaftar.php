<?php
session_start();
include 'koneksi.php';

// Proses Hapus Data
if(isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $query_hapus = "DELETE FROM siswa WHERE id = $id";
    if(mysqli_query($koneksi, $query_hapus)) {
        echo "<script>alert('Data berhasil dihapus!'); window.location='lihat_pendaftar.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!');</script>";
    }
}

$query = "SELECT * FROM siswa ORDER BY tanggal_daftar DESC";
$result = mysqli_query($koneksi, $query);

include 'header.php';
?>

<style>
    .container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 20px;
    }

    .page-header {
        background-color: white;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        text-align: center;
    }

    .page-header h2 {
        color: #4CAF50;
        margin-bottom: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #4CAF50;
        color: white;
        font-weight: bold;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    .btn {
        padding: 8px 15px;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        font-size: 14px;
        margin: 2px;
        display: inline-block;
    }
    
    .btn-edit {
        background-color: #FFA500;
    }
    
    .btn-edit:hover {
        background-color: #FF8C00;
    }
    
    .btn-hapus {
        background-color: #FF0000;
    }
    
    .btn-hapus:hover {
        background-color: #CC0000;
    }
    
    .aksi {
        white-space: nowrap;
    }
</style>

<div class="container">
    <div class="page-header">
        <h2>Data Pendaftar Siswa Baru</h2>
        <p>SMPN 2 Pujut - Tahun Ajaran <?php echo date('Y'); ?>/<?php echo date('Y')+1; ?></p>
    </div>

    <table>
        <tr>
            <th>No. Pendaftaran</th>
            <th>Nama Lengkap</th>
            <th>Tempat, Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Agama</th>
            <th>Asal Sekolah</th>
            <th>Nilai UN</th>
            <th>Tanggal Daftar</th>
            <th>Aksi</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['no_pendaftaran']; ?></td>
            <td><?php echo $row['nama_lengkap']; ?></td>
            <td><?php echo $row['tempat_lahir'] . ', ' . date('d-m-Y', strtotime($row['tanggal_lahir'])); ?></td>
            <td><?php echo $row['jenis_kelamin']; ?></td>
            <td><?php echo $row['agama']; ?></td>
            <td><?php echo $row['asal_sekolah']; ?></td>
            <td><?php echo $row['nilai_un']; ?></td>
            <td><?php echo date('d-m-Y H:i:s', strtotime($row['tanggal_daftar'])); ?></td>
            <td class="aksi">
                <a href="edit_pendaftar.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">Edit</a>
                <a href="javascript:void(0);" onclick="konfirmasiHapus(<?php echo $row['id']; ?>)" class="btn btn-hapus">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<script>
function konfirmasiHapus(id) {
    if(confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        window.location.href = 'lihat_pendaftar.php?hapus=' + id;
    }
}
</script>
</body>
</html> 