<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    
    // Debug: Print values
    echo "Debug - Username: " . $username . "<br>";
    echo "Debug - Nama Lengkap: " . $nama_lengkap . "<br>";
    echo "Debug - Email: " . $email . "<br>";
    
    // Cek username sudah digunakan atau belum
    $check_username = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");
    if(!$check_username) {
        echo "Error in check_username query: " . mysqli_error($koneksi);
    }
    
    // Cek email sudah digunakan atau belum
    $check_email = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");
    if(!$check_email) {
        echo "Error in check_email query: " . mysqli_error($koneksi);
    }
    
    if(mysqli_num_rows($check_username) > 0) {
        $error = "Username sudah digunakan!";
    } elseif(mysqli_num_rows($check_email) > 0) {
        $error = "Email sudah digunakan!";
    } else {
        // Insert ke database
        $query = "INSERT INTO users (username, password, nama_lengkap, email, role) 
                  VALUES ('$username', '$password', '$nama_lengkap', '$email', 'admin')";
        
        // Debug: Print query
        echo "Debug - Query: " . $query . "<br>";
        
        if(mysqli_query($koneksi, $query)) {
            $success = "Admin baru berhasil ditambahkan!";
            // Reset form setelah berhasil
            $_POST = array();
        } else {
            $error = "Error in insert query: " . mysqli_error($koneksi);
        }
    }
}

// Debug: Print session info
echo "Debug - Session user_id: " . $_SESSION['user_id'] . "<br>";
echo "Debug - Session role: " . $_SESSION['role'] . "<br>";

include 'header.php';
?>

<style>
    .container {
        max-width: 600px;
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
    input[type="email"],
    input[type="password"] {
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

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>

<div class="container">
    <div class="form-header">
        <h2>Daftar Admin Baru</h2>
        <p>SMPN 2 Pujut</p>
    </div>

    <?php if(isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap:</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo isset($_POST['nama_lengkap']) ? htmlspecialchars($_POST['nama_lengkap']) : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
        </div>

        <button type="submit" name="submit">Daftar Admin</button>
    </form>
</div>

<!-- Tambahkan script untuk menampilkan alert dan clear form -->
<script>
<?php if(isset($success)): ?>
    alert("<?php echo $success; ?>");
    // Clear form setelah berhasil
    document.querySelector('form').reset();
<?php endif; ?>
</script>

</body>
</html> 