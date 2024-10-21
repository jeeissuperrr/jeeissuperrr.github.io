<?php
// Koneksi database
$host = 'localhost';
$db_username = 'root';
$db_password = '';
$database = 'crud_db';

try {
    $koneksi = new mysqli($host, $db_username, $db_password, $database);
} catch (mysqli_sql_exception $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Proses pencarian
if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search = trim($_GET['search']);
    $stmt = $koneksi->prepare("SELECT * FROM produk WHERE nama LIKE ?");
    $search_param = "%$search%"; // Menambahkan wildcard untuk pencarian
    $stmt->bind_param("s", $search_param);
    $stmt->execute();
    $result = $stmt->get_result();

    // Menampilkan hasil pencarian
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()): ?>
            <div class="card">
                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['nama']); ?>">
                <h3><?php echo htmlspecialchars($row['nama']); ?></h3>
                <p>Harga: Rp. <?php echo number_format($row['harga']); ?></p>
                <div class="more">
                    <button class="add-to-cart">
                        <i class="fas fa-shopping-cart" 
                           data-name="<?php echo htmlspecialchars($row['nama']); ?>" 
                           data-price="<?php echo htmlspecialchars($row['harga']); ?>">
                        </i> 
                        Tambahkan ke Keranjang
                    </button>
                    <button>
                        <i class="fas fa-info-circle"></i> 
                        Lihat lebih lanjut
                    </button>
                </div>
            </div>
        <?php endwhile;
    } else {
        echo '<p>Tidak ada produk ditemukan.</p>';
    }
} else {
    echo '<p>Silakan masukkan kata kunci untuk mencari produk.</p>';
}
?>
