<?php
session_start();

$host = 'localhost';
$db_username = 'root'; // Username untuk koneksi ke database
$db_password = '';     // Password untuk koneksi ke database
$database = 'crud_db'; 

try {
    $koneksi = new mysqli($host, $db_username, $db_password, $database);
} catch (mysqli_sql_exception $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Proses registrasi
$message = ''; // Variabel untuk menyimpan pesan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Simpan pengguna baru
    $stmt = $koneksi->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        $message = "Registrasi berhasil! <a href='login.php'>Login sekarang</a>";
    } else {
        $message = "Registrasi gagal: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - JeeStore Admin</title>
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
        .register-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .register-container h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }
        .register-container input[type="text"], 
        .register-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .register-container button {
            width: 100%;
            padding: 10px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .register-container button:hover {
            background-color: goldenrod;
        }
        .register-container p {
            text-align: center;
            margin-top: 20px;
        }
        .register-container .message {
            color: green;
            text-align: center;
            margin-top: 10px;
        }
        .register-container .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div class="register-container">
        <h2>Registrasi JeeStore</h2>
        <form action="" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Masukkan Username" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
            
            <button type="submit">DAFTAR</button>
        </form>
        
        <!-- Menampilkan pesan di bawah form -->
        <?php if (!empty($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>

        

        <p>Sudah punya akun? <a href="login.php">Login sekarang</a></p>
        <button onclick="window.location.href='index.php'">Kembali</button>
    </div>

</body>
</html>
