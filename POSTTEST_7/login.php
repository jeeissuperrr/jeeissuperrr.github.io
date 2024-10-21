<?php
session_start();

$host = 'localhost';
$db_username = 'root'; // Username untuk koneksi ke database
$db_password = '';    // Password untuk koneksi ke database
$database = 'crud_db'; 

try {
    $koneksi = new mysqli($host, $db_username, $db_password, $database);
} catch (mysqli_sql_exception $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Proses login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ambil data pengguna dari database
    $stmt = $koneksi->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verifikasi password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: landing_page.php"); 
        exit();
    } else {
        $error_message = "Username atau password salah!";
    }

    // Tutup koneksi
    $stmt->close();
    $koneksi->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - JeeStore Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .login-container h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }
        .login-container input[type="text"], 
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .login-container button:hover {
            background-color: goldenrod;
        }
        .login-container p {
            text-align: center;
            margin-top: 20px;
        }
        .login-container .error {
            color: red;
            text-align: center;
        }
        .login-container .small-button {
            width: auto; 
            padding: 5px 10px; 
            background-color: gray; 
            color: white; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            transition: background-color 0.3s ease; 
            margin-top: 10px; 
        }

        .login-container .small-button:hover {
            background-color: darkgray; 
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Admin JeeStore</h2>
        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <label for="username">Login</label>
            <input type="text" id="username" name="username" placeholder="Masukkan Username" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
            
            <button type="submit">LOGIN</button>
            <button type="button" class="small-button" onclick="window.location.href='index.php'">Kembali</button>
        </form>
        <p>Belum punya akun? <a href="register.php">Daftar</a></p>

    </div>

</body>
</html>
