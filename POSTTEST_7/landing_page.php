<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crud_db";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_GET['hapus'])) {
    // Pastikan parameter 'hapus' diterima
    $id = (int) $_GET['hapus'];

    // Query untuk mengambil data sebelum menghapus
    $sql = $conn->prepare("SELECT * FROM toko_sendal WHERE id_sendal = ?");
    $sql->bind_param("i", $id);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        // Ambil data sendal
        $datasendal = $result->fetch_assoc();

        // Hapus record dari database
        $query = $conn->prepare("DELETE FROM toko_sendal WHERE id_sendal = ?");
        $query->bind_param("i", $id);
        $delete_result = $query->execute();

        // Hapus gambar terkait jika data dihapus
        if ($delete_result) {
            unlink('image/' .$datasendal['gambar']); // Hapus file gambar

            echo "
                <script>
                    alert('Berhasil menghapus data sendal');
                    document.location.href = 'landing_page.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Gagal Menghapus data');
                    document.location.href = 'landing_page.php';
                </script>
            ";
        }
    } else {
        echo "
            <script>
                alert('Data sendal tidak ditemukan!');
                document.location.href = 'landing_page.php';
            </script>
        ";
    }
}

if (isset($_GET['edit'])) {
    // Ambil ID sendal yang akan diedit
    $id = $_GET['edit'];

    // Query untuk mengambil data sandal sebelumnya
    $sql = $conn->prepare("SELECT * FROM toko_sendal WHERE id_sendal = ?");
    $sql->bind_param("i", $id);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $datasendal = $result->fetch_assoc(); // Mengambil data sandal sebelumnya

        // Ambil data yang dikirim dari form
        $nama = $_POST['nama'];
        $harga = $_POST['harga'];
        $foto = $_FILES['gambar']['name'];
        $foto_tmp = $_FILES['gambar']['tmp_name'];
        $extensi = explode('.', $foto);
        $extensi = strtolower(end($extensi));
        $name_baru = date('Y-m-d H.m.s') . '.' . $extensi;
        $support = ['jpg', 'jpeg', 'png'];
        $size = $_FILES['gambar']['size'];
        $max_size = 2 * 1024 * 1024;

        // Hapus file gambar lama
        unlink('image/' . $datasendal['gambar']); // Hapus gambar lama

        // Cek jika ada gambar baru yang diupload
        if (!empty($foto)) {
            // Cek ekstensi gambar dan ukuran file
            if (in_array($extensi, $support)) {
                if ($size <= $max_size) {
                    // Pindahkan file gambar baru ke folder
                    if (move_uploaded_file($foto_tmp, 'image/' . $name_baru)) {
                        // Query untuk update data dengan gambar baru
                        $query = $conn->prepare("UPDATE toko_sendal SET nama = ?, harga = ?, gambar = ? WHERE id_sendal = ?");
                        $query->bind_param("sssi", $nama, $harga, $name_baru, $id);
                        $result_update = $query->execute();

                        if ($result_update) {
                            echo "
                                <script>
                                    alert('Berhasil memperbarui data sandal!');
                                    location.href = 'landing_page.php';
                                </script>
                            ";
                        } else {
                            echo "
                                <script>
                                    alert('Gagal memperbarui data sandal!');
                                </script>
                            ";
                        }
                    }
                } else {
                    echo "
                        <script>
                            alert('Ukuran file terlalu besar. Maksimal 2MB.');
                        </script>
                    ";
                }
            } else {
                echo "
                    <script>
                        alert('Ekstensi file tidak diperbolehkan. Hanya JPG, JPEG, PNG yang diperbolehkan.');
                    </script>
                ";
            }
        } else {
            // Jika tidak ada gambar baru, hanya update data nama dan harga
            $query = $conn->prepare("UPDATE toko_sendal SET nama = ?, harga = ? WHERE id_sendal = ?");
            $query->bind_param("ssi", $nama, $harga, $id);
            $result_update = $query->execute();

            if ($result_update) {
                echo "
                    <script>
                        alert('Berhasil memperbarui data sandal tanpa mengganti gambar!');
                        location.href = 'landing_page.php';
                    </script>
                ";
            } else {
                echo "
                    <script>
                        alert('Gagal memperbarui data sandal!');
                    </script>
                ";
            }
        }
    }
}

// Query untuk mengambil data sandal dari database
$sql = "SELECT * FROM toko_sendal";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Tampilkan data dalam bentuk tabel
$output = "";
if ($result->num_rows > 0) {
    $output .= "<h1>Data Sendal Terbaru</h1>";
    $output .= "<table border='1'>";
    $output .= "<tr><th>Nama Sandal</th><th>Harga</th><th>Gambar</th><th>Aksi</th></tr>";
    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>";
        $output .= "<td>" . $row["nama"] . "</td>";
        $output .= "<td>Rp " . number_format($row["harga"], 2, ',', '.') . "</td>";
        $output .= "<td><img src='image/" . $row["gambar"] . "' width='100' height='100'></td>";
        $output .= "<td><a href='edit.php?edit=" . $row["id_sendal"] . "'>Edit</a> | <a href='?hapus=" . $row["id_sendal"] . "' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?');\">Hapus</a></td>";
        $output .= "</tr>";
    }
    $output .= "</table>";
} else {
    $output .=  "
                    <script>
                        alert('Data sendal tidak ditemukan!');
                        document.location.href = 'admin.php';
                    </script>
                ";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page JeeStore</title>
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
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd ;
            padding: 10px;
            text-align: left;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        a {
            text-decoration: none;
            color: #337ab7;
        }
        a:hover {
            color: #23527c;
        }
    </style>
</head>
<body>
    
    <?php echo $output; ?>
    <a href="logout.php" style="padding: 10px; background-color: #f44336; color: white; text-decoration: none; border-radius: 5px;">LOGOUT</a>
    
</body>
</html>
