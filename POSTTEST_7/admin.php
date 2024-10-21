<?php
// Mulai session
ob_start(); // Memulai output buffering untuk mencegah output sebelum header()

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crud_db";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nama']) && isset($_POST['harga']) && isset($_FILES['gambar'])) {
        $nama = $_POST['nama'];
        $harga = $_POST['harga'];
        $gambar = $_FILES['gambar'];

        if ($gambar['error'] == 0) {
            $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'mp4'); 
            $extension = pathinfo($gambar['name'], PATHINFO_EXTENSION);
            if (!in_array(strtolower($extension), $allowedExtensions)) {
                echo "<p style='color: red;'>Hanya file gambar dengan ekstensi jpg, jpeg, png, gif, dan bmp yang diizinkan.</p>";
            } else {
                
                $maxFileSize = 1 * 1024 * 1024; 
                if ($gambar['size'] > $maxFileSize) {
                    echo "<script> alert ('File terlalu besar, ukuran maksimal adalah 1MB') </script>";

                } else {
                    // Buat nama file berdasarkan tanggal
                    $date = date('Y-m-d');
                    $filename = $date . '-' . uniqid() . '.' . $extension;

                    // Tentukan folder tempat penyimpanan gambar
                    $targetDir = 'image/';
                    if (!file_exists($targetDir)) {
                        mkdir($targetDir, 0777, true);
                    }
                    $targetFile = $targetDir . $filename;
                    move_uploaded_file($gambar['tmp_name'], $targetFile);

                    // Masukkan data sandal ke dalam database
                    $sql = "INSERT INTO toko_sendal (nama, harga, gambar) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sss", $nama, $harga, $filename);
                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {
                        // Redirect ke landing_page.php
                        header("Location: landing_page.php");
                        exit(); // Pastikan skrip berhenti setelah header()
                    } else {
                        echo "<p style='color: red;'>Terjadi kesalahan: " . $stmt->error . "</p>";
                    }
                }
            }
        } else {
            echo "<p style='color: red;'>Terjadi kesalahan saat mengupload gambar!</p>";
        }
    }
}

$conn->close();
ob_end_flush(); // Mengakhiri output buffering
?>



<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard JeeStore - Tambah Sandal</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .admin-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
            font-size: 1.1em;
        }
        input[type="text"], input[type="number"] {
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            margin-top: 20px;
            padding: 10px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: goldenrod;
        }
    </style>
</head>
<body>

    <div class="admin-container">
        <h1>Admin JeeStore</h1>
        <br>

        <h2>Tambah Sandal Baru</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
            <label for="nama">Nama Sandal:</label>
            <input type="text" id="nama" name="nama" placeholder="Masukkan nama sandal" required>

            <label for="harga">Harga:</label>
            <input type="number" id="harga" name="harga" placeholder="Masukkan harga sandal" required>

            <label for="gambar">Gambar:</label>
            <input type="file" id="gambar" name="gambar" placeholder="Masukkan gambar" required>

            <button type="submit">Tambahkan Sandal</button>
        </form>

    </div>

</body>
</html>