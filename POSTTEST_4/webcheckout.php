<?php
// Simulasi data keranjang belanja (seharusnya berasal dari database atau sesi pengguna)
$cart = [
    ['name' => 'Produk 1', 'price' => 50000, 'quantity' => 2],
    ['name' => 'Produk 2', 'price' => 75000, 'quantity' => 1],
    ['name' => 'Produk 3', 'price' => 150000, 'quantity' => 3],
];

$name = $phone = $address = "";
$orderDetails = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $address = htmlspecialchars($_POST['address']);

    // Membuat detail order
    $orderDetails = "Nama: $name<br>Nomor HP: $phone<br>Alamat: $address<br><br>";
    $orderDetails .= "Barang yang dibeli:<br>";

    foreach ($cart as $item) {
        $orderDetails .= $item['name'] . " - Harga: Rp. " . number_format($item['price'], 0, ',', '.') . " - Jumlah: " . $item['quantity'] . "<br>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url(genshin-impact.jpg);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
        }
        h2 {
            text-align: center;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"],
        input[type="number"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: goldenrod;
        }
        #result {
            margin-top: 20px;
            display: none;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Checkout</h2>
        
        <!-- Form untuk input data pengguna -->
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="name">Nama:</label>
            <input type="text" id="name" name="name" required>

            <label for="phone">Nomor HP:</label>
            <input type="number" id="phone" name="phone" required>

            <label for="address">Alamat:</label>
            <input type="text" id="address" name="address" required>

            <button type="submit">Checkout</button>
        </form>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <div id="result" style="display: block;">
                <h3>Detail Pembelian:</h3>
                <p><?php echo $orderDetails; ?></p>
                <button onclick="window.location.href = 'index.html'">Lanjutkan Belanja</button>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
