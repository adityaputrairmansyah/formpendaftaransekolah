<?php
include 'koneksi.php';

// Mengambil data siswa berdasarkan ID
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM siswa WHERE id = $id";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);
    
    if(!$data) {
        echo "<script>alert('Data tidak ditemukan!'); window.location='lihat_pendaftar.php';</script>";
        exit();
    }
} else {
    header("Location: lihat_pendaftar.php");
    exit();
}

// Proses Update Data
if(isset($_POST['update'])) {
    $nama_lengkap = $_POST['nama_lengkap'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $alamat = $_POST['alamat'];
    $nama_ortu = $_POST['nama_ortu'];
    $no_hp = $_POST['no_hp'];
    $asal_sekolah = $_POST['asal_sekolah'];
    $nilai_un = $_POST['nilai_un'];

    $query_update = "UPDATE siswa SET 
                    nama_lengkap = '$nama_lengkap',
                    tempat_lahir = '$tempat_lahir',
                    tanggal_lahir = '$tanggal_lahir',
                    jenis_kelamin = '$jenis_kelamin',
                    agama = '$agama',
                    alamat = '$alamat',
                    nama_ortu = '$nama_ortu',
                    no_hp = '$no_hp',
                    asal_sekolah = '$asal_sekolah',
                    nilai_un = '$nilai_un'
                    WHERE id = $id";

    if(mysqli_query($koneksi, $query_update)) {
        echo "<script>alert('Data berhasil diupdate!'); window.location='lihat_pendaftar.php';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pendaftar - SMPN 2 Pujut</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="date"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .btn-kembali {
            background-color: #666;
            margin-right: 10px;
        }
        .btn-kembali:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <h2>Edit Data Pendaftar</h2>
    
    <form method="POST" action="">
        <div class="form-group">
            <label>No. Pendaftaran:</label>
            <input type="text" value="<?php echo $data['no_pendaftaran']; ?>" disabled>
        </div>

        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap:</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo $data['nama_lengkap']; ?>" required>
        </div>

        <div class="form-group">
            <label for="tempat_lahir">Tempat Lahir:</label>
            <input type="text" id="tempat_lahir" name="tempat_lahir" value="<?php echo $data['tempat_lahir']; ?>" required>
        </div>

        <div class="form-group">
            <label for="tanggal_lahir">Tanggal Lahir:</label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo $data['tanggal_lahir']; ?>" required>
        </div>

        <div class="form-group">
            <label for="jenis_kelamin">Jenis Kelamin:</label>
            <select id="jenis_kelamin" name="jenis_kelamin" required>
                <option value="Laki-laki" <?php echo ($data['jenis_kelamin'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                <option value="Perempuan" <?php echo ($data['jenis_kelamin'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
            </select>
        </div>

        <div class="form-group">
            <label for="agama">Agama:</label>
            <select id="agama" name="agama" required>
                <?php
                $agama_list = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
                foreach($agama_list as $agama_option) {
                    $selected = ($data['agama'] == $agama_option) ? 'selected' : '';
                    echo "<option value='$agama_option' $selected>$agama_option</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat:</label>
            <textarea id="alamat" name="alamat" rows="3" required><?php echo $data['alamat']; ?></textarea>
        </div>

        <div class="form-group">
            <label for="nama_ortu">Nama Orang Tua/Wali:</label>
            <input type="text" id="nama_ortu" name="nama_ortu" value="<?php echo $data['nama_ortu']; ?>" required>
        </div>

        <div class="form-group">
            <label for="no_hp">Nomor HP:</label>
            <input type="text" id="no_hp" name="no_hp" value="<?php echo $data['no_hp']; ?>" required>
        </div>

        <div class="form-group">
            <label for="asal_sekolah">Asal Sekolah:</label>
            <input type="text" id="asal_sekolah" name="asal_sekolah" value="<?php echo $data['asal_sekolah']; ?>" required>
        </div>

        <div class="form-group">
            <label for="nilai_un">Nilai Ujian Nasional:</label>
            <input type="number" id="nilai_un" name="nilai_un" step="0.01" min="0" max="100" value="<?php echo $data['nilai_un']; ?>" required>
        </div>

        <a href="lihat_pendaftar.php" class="btn btn-kembali" style="text-decoration: none; display: inline-block;">Kembali</a>
        <button type="submit" name="update">Update Data</button>
    </form>
</body>
</html> 