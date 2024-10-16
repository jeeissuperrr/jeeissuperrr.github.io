<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crud_db"; // Nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID sandal dari URL
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    // Query untuk mengambil data sandal berdasarkan ID
    $sql = "SELECT * FROM toko_sendal WHERE id_sendal=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $sandal = $result->fetch_assoc();
}

// Proses ketika form di-submit untuk mengupdate data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];

    // Jika gambar diubah, upload gambar baru
    if ($_FILES['gambar']['error'] == 0) {
        $date = date('Y-m-d');
        $filename = $date . '-' . uniqid() . '.' . pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $targetDir = 'image/';
        $targetFile = $targetDir . $filename;

        // Cek jika file sudah ada
        if (file_exists($targetFile)) {
            echo "File sudah ada!";
            exit;
        }

        // Upload file
        if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
            echo "Gagal upload file!";
            exit;
        }
    } else {
        $filename = $sandal['gambar']; // Gunakan gambar lama jika tidak diubah
    }

    // Query untuk mengupdate data sandal
    $sql = "UPDATE toko_sendal SET nama=?, harga=?, gambar=? WHERE id_sendal=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nama, $harga, $filename, $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Data berhasil diperbarui!";
        header("Location: landing_page.php");
        exit;
    } else {
        echo "Terjadi kesalahan saat memperbarui data: " . $stmt->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Sandal</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], input[type="number"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px 20px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: goldenrod;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Sandal</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="nama">Nama Sandal:</label>
            <input type="text" id="nama" name="nama" value="<?php echo $sandal['nama']; ?>" required>

            <label for="harga">Harga:</label>
            <input type="number" id="harga" name="harga" value="<?php echo $sandal['harga']; ?>" required>

            <label for="gambar">Gambar:</label>
            <input type="file" id="gambar" name="gambar">

            <button type="submit">Simpan</button>
        </form>
    </div>
</body>
</html>