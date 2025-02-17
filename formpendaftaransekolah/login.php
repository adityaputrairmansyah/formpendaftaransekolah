<?php
session_start();
include 'koneksi.php';

if(isset($_SESSION['user_id'])) {
    if($_SESSION['role'] == 'admin') {
        header("Location: dashboard.php");
    } else {
        header("Location: user_dashboard.php");
    }
    exit();
}

if(isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']);
    
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($koneksi, $query);
    
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['nama_lengkap'] = $row['nama_lengkap'];
        $_SESSION['role'] = $row['role'];
        
        if($row['role'] == 'admin') {
            header("Location: dashboard.php");
        } else {
            header("Location: user_dashboard.php");
        }
        exit();
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SMPN 2 Pujut</title>
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
        input[type="password"] {
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
            <h2>Login</h2>
            <p>Silakan login untuk melanjutkan</p>
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

            <button type="submit" name="login" class="btn">Login</button>
        </form>

        <div class="links">
            Belum punya akun? <a href="register.php">Register di sini</a>
        </div>
    </div>
</body>
</html> 