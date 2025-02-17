<?php
session_start();
include 'koneksi.php';

if (isset($_POST['submit'])) {
    $no_pendaftaran = "SMPN2P" . date('Y') . rand(1000, 9999);
    $nama_lengkap = $_POST['nama_lengkap'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $alamat = $_POST['alamat'];
    $nama_ortu = $_POST['nama_ortu'];
    $no_hp = $_POST['no_hp'];
    $asal_sekolah = $_POST['asal_sekolah'];
    // Nilai UN hanya diisi jika admin
    $nilai_un = ($_SESSION['role'] == 'admin') ? $_POST['nilai_un'] : NULL;
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO siswa (user_id, no_pendaftaran, nama_lengkap, tempat_lahir, tanggal_lahir, 
              jenis_kelamin, agama, alamat, nama_ortu, no_hp, asal_sekolah, nilai_un) 
              VALUES ('$user_id', '$no_pendaftaran', '$nama_lengkap', '$tempat_lahir', '$tanggal_lahir', 
              '$jenis_kelamin', '$agama', '$alamat', '$nama_ortu', '$no_hp', '$asal_sekolah', " . 
              ($nilai_un !== NULL ? "'$nilai_un'" : "NULL") . ")";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Pendaftaran berhasil! Nomor pendaftaran Anda: $no_pendaftaran');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($koneksi) . "');</script>";
    }
}

// Ambil data user untuk mengisi nama lengkap otomatis
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($koneksi, $query);
$user_data = mysqli_fetch_assoc($result);

include 'header.php';
?>

<style>
    .container {
        max-width: 800px;
        margin: 40px auto;
        padding: 20px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .form-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .form-header h2 {
        color: #4CAF50;
        margin-bottom: 10px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #333;
        font-weight: bold;
    }

    input[type="text"],
    input[type="date"],
    input[type="number"],
    select,
    textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    button {
        background-color: #4CAF50;
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        width: 100%;
    }

    button:hover {
        background-color: #45a049;
    }
</style>

<div class="container">
    <div class="form-header">
        <h2>Formulir Pendaftaran Siswa Baru</h2>
        <p>SMPN 2 Pujut - Tahun Ajaran <?php echo date('Y'); ?>/<?php echo date('Y')+1; ?></p>
    </div>
    
    <form method="POST" action="">
        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap:</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo $user_data['nama_lengkap']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="tempat_lahir">Tempat Lahir:</label>
            <input type="text" id="tempat_lahir" name="tempat_lahir" required>
        </div>

        <div class="form-group">
            <label for="tanggal_lahir">Tanggal Lahir:</label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>
        </div>

        <div class="form-group">
            <label for="jenis_kelamin">Jenis Kelamin:</label>
            <select id="jenis_kelamin" name="jenis_kelamin" required>
                <option value="">Pilih Jenis Kelamin</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>

        <div class="form-group">
            <label for="agama">Agama:</label>
            <select id="agama" name="agama" required>
                <option value="">Pilih Agama</option>
                <option value="Islam">Islam</option>
                <option value="Kristen">Kristen</option>
                <option value="Katolik">Katolik</option>
                <option value="Hindu">Hindu</option>
                <option value="Buddha">Buddha</option>
                <option value="Konghucu">Konghucu</option>
            </select>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat:</label>
            <textarea id="alamat" name="alamat" rows="3" required></textarea>
        </div>

        <div class="form-group">
            <label for="nama_ortu">Nama Orang Tua/Wali:</label>
            <input type="text" id="nama_ortu" name="nama_ortu" required>
        </div>

        <div class="form-group">
            <label for="no_hp">Nomor HP:</label>
            <input type="text" id="no_hp" name="no_hp" required>
        </div>

        <div class="form-group">
            <label for="asal_sekolah">Asal Sekolah:</label>
            <input type="text" id="asal_sekolah" name="asal_sekolah" required>
        </div>

        <?php if($_SESSION['role'] == 'admin'): ?>
        <div class="form-group">
            <label for="nilai_un">Nilai Ujian Nasional:</label>
            <input type="number" id="nilai_un" name="nilai_un" step="0.01" min="0" max="100" required>
        </div>
        <?php endif; ?>

        <button type="submit" name="submit">Daftar</button>
    </form>
</div>
</body>
</html> 