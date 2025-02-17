<?php
include 'koneksi.php';

if(isset($_POST['register'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);

    $check_username = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");
    if(mysqli_num_rows($check_username) > 0) {
        $error = "Username sudah digunakan!";
    } else {
        $query = "INSERT INTO users (username, password, nama_lengkap, email, role) 
                 VALUES ('$username', '$password', '$nama_lengkap', '$email', 'user')";
        if(mysqli_query($koneksi, $query)) {
            echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.php';</script>";
            exit();
        } else {
            $error = "Registrasi gagal!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SMPN 2 Pujut</title>
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
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        .nav-right {
            float: right;
            display: flex;
            align-items: center;
        }

        .container {
            max-width: 400px;
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
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            width: 100%;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .error-message {
            color: #ff0000;
            margin-bottom: 15px;
            text-align: center;
        }

        .links {
            text-align: center;
            margin-top: 15px;
        }

        .links a {
            color: #4CAF50;
            text-decoration: none;
        }

        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>SMPN 2 Pujut</h1>
        <div class="nav-menu">
            <span>Sistem Pendaftaran Siswa Baru</span>
        </div>
    </div>

    <div class="container">
        <div class="form-header">
            <h2>Register</h2>
            <p>Daftar akun baru</p>
        </div>
        
        <?php if(isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <button type="submit" name="register" class="btn">Register</button>
        </form>

        <div class="links">
            Sudah punya akun? <a href="login.php">Login di sini</a>
        </div>
    </div>
</body>
</html> 