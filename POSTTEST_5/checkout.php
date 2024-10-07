<?php
session_start();


if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: tambahkeranjang.php"); 
    exit();
}


$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 20px;
            background-image : url('kimi.jpg');
            background-size : cover ;
            background-repeat : no-repeat ;
            background-attachment : fixed ;
            background-position : center ;

        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .total {
            font-weight: bold;
            font-size: 20px;
            margin-top: 20px;
            text-align: right;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 15px;
            margin-top: 20px;
            background-color: #28a745;
            background-size : cover ;
            color: white;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #218838;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Invoice Pembelian</h1>

    <table>
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td>Rp. <?php echo number_format($item['price'], 0, ',', '.'); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>Rp. <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="total">
        Total Harga: Rp. <?php echo number_format($total, 0, ',', '.'); ?>
    </div>

    <a href="tambahkeranjang.php" class="btn">Kembali</a>
</div>

<div class="footer">
    &copy; JeeStore
</div>

<?php

unset($_SESSION['cart']);
?>

</body>
</html>
