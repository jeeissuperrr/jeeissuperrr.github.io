<?php
session_start();

// Database connection
$host = "localhost";
$user = "root"; 
$password = ""; 
$dbname = "crud_db"; 

$conn = new mysqli($host, $user, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}


if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Menangani penambahan produk ke keranjang
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['name']) && isset($_GET['price'])) {
    $name = htmlspecialchars($_GET['name']);
    $price = floatval($_GET['price']);

    // Menambahkan produk ke keranjang
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['name'] === $name) {
            $item['quantity']++;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = [
            'name' => $name,
            'price' => $price,
            'quantity' => 1,
        ];
    }

    echo "<script>alert('$name telah ditambahkan ke keranjang!');</script>";
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update']) && isset($_POST['name']) && isset($_POST['quantity'])) {
        $name = htmlspecialchars($_POST['name']);
        $quantity = intval($_POST['quantity']);

        
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['name'] === $name) {
                $item['quantity'] = $quantity;
                break;
            }
        }
    } elseif (isset($_POST['remove']) && isset($_POST['name'])) {
        $name = htmlspecialchars($_POST['name']);

        
        $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($name) {
            return $item['name'] !== $name;
        });
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('genshin-impact.jpg'); 
            background-size: cover;
            background-position: center;
            color: #333;
        }
        header {
            text-align: center;
            padding: 20px;
            background-color: transparent;
            color: white;
        }
        main {
            padding: 20px;
            max-width: 800px;
            margin: auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .cart-item input {
            width: 50px;
            text-align: center;
        }
        footer {
            text-align: center;
            padding: 20px;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #218838;
        }
        .button.secondary {
            background-color: #007bff;
        }
        .button.secondary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<header>
    <h1>Keranjang Belanja</h1>
</header>

<main>
    <h2><b>Produk dalam Keranjang</b></h2>
    <hr>
    <?php if (empty($_SESSION['cart'])): ?>
        <p>Keranjang Anda kosong.</p>
    <?php else: ?>
        <form method="POST" action="">
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <div class="cart-item">
                    <span><?php echo htmlspecialchars($item['name']); ?></span>
                    <span>Rp. <?php echo number_format($item['price'], 0, ',', '.'); ?></span>
                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1">
                    <input type="hidden" name="name" value="<?php echo htmlspecialchars($item['name']); ?>">
                    <button type="submit" name="update">Update</button>
                    <button type="submit" name="remove">Hapus</button>
                </div>
            <?php endforeach; ?>
        </form>
    <?php endif; ?>

    <div class="button-group">
        <a href="checkout.php" class="button">Checkout</a>
        <a href="index.html" class="button secondary">Kembali</a>
    </div>
</main>

<footer>
    <p>&copy;JeeStore</p>
</footer>

</body>
</html>

<?php
$conn->close();
?>
