<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POSTTEST 7</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
   
   
    <style>
        
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: black;
            color: white;
            transition: background-color 0.3s ease;
        }
        nav ul {
            display: flex;
            list-style: none;
            gap: 20px;
        }
        nav ul li {
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        nav ul li:hover {
            background-color: #555;
        }
        a {
            color: white;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        
        .carousel, .main-content, .about, .footer {
            padding: 20px;
            margin: 20px auto;
            max-width: 1200px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
            transition: background-color 0.3s ease;
        }

        
        .footer {
            background-color: black;
            color: white;
            text-align: center;
            padding: 10px 0;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        
        .dark-mode {
            background-color: #121212;
            color: #e0e0e0;
        }
        .dark-mode header, .dark-mode .footer {
            background-color: #222;
            color: #e0e0e0;
        }
        .dark-mode a {
            color: #e0e0e0;
        }
        .dark-mode .carousel, .dark-mode .main-content, .dark-mode .about {
            background-color: #1e1e1e;
            color: #e0e0e0;
        }

        
        .hamburger {
            display: none;
            cursor: pointer;
            font-size: 30px;
        }
        nav ul {
            flex-direction: row;
        }
        @media (max-width: 768px) {
            nav ul {
                display: none;
                flex-direction: column;
                background-color: #333;
                position: absolute;
                top: 60px;
                right: 0;
                width: 200px;
            }
            nav ul.show {
                display: block;
            }
            .hamburger {
                display: block;
            }
        }

        
        .popup-box {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border: 1px solid #ccc;
            padding: 20px;
            display: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            border-radius: 10px;
        }
        .popup-box p {
            margin: 0 0 10px 0;
        }
        .popup-box button {
            cursor: pointer;
            padding: 5px 10px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .popup-box button:hover {
            background-color: #0056b3;
        }

        
        .card {
            border: 1px solid #ddd;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
            border-radius: 10px;
            background-color: white;
            transition: transform 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card img {
            width: 150px;
            height: auto;
        }
        .card h3 {
            margin: 10px 0;
            font-size: 1.5em;
        }
        .card p {
            margin: 0;
            font-size: 1.2em;
        }
        .more {
            margin-top: 10px;
        }
        .more button {
            cursor: pointer;
            padding: 8px 12px;
            margin-right: 5px;
            border: none;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .more button:hover {
            background-color: goldenrod;
        }
        .more button i {
            margin-right: 5px;
        }
        #bio-popup-btn {
            background-color: goldenrod;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #bio-popup-btn:hover {
            background-color: #218838; 
        }
        .loading {
            display: none;
            text-align: center;
            margin : 20px;
        }
    </style>

</head>


<body class="light-mode">

    <header>
        <figure class="logo">
            <img src="logo_1.png" alt="Logo" width="110px">
        </figure>
        <nav>
            <ul id="nav-list">
                <li><a href="index.php">Home</a></li>
                <li><a href="#about">About Me</a></li>
                <li><a href="#" id="dark-mode-toggle">Dark Mode</a></li>
                <li><a href="login.php" id="login-btn"style="color : white;">Login</a></li>
            </ul>
            <i class="fa fa-bars hamburger" id="hamburger"></i>
        </nav>
    </header>
    <

    <section class="carousel" id="home">
        <h1><b>JeeStore</b></h1>
        <p>SENDAL BERKUALITAS DENGAN HARGA TERJANGKAU!</p>
        <main class="main-content">
        <!-- Form Pencarian -->
        <h2><b>Cari Item</b></h2>
        <form id="search-form" action="" method="GET">
            <input type="text" id="search-input" name="search" placeholder="Cari produk..." required>
            <button type="submit">Cari</button>
        </form>
        <div class="loading" id="loading">Loading...</div>
        <div id="search-result"></div>
    </section>

    <main class="main-content">
        <h2><b>Produk</b></h2>
        <hr>
        

        <?php
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
        $search = '';
        if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
            $search = trim($_GET['search']);
            $stmt = $koneksi->prepare("SELECT * FROM produk WHERE nama LIKE ?");
            $search_param = "%$search%"; // Menambahkan wildcard untuk pencarian
            $stmt->bind_param("s", $search_param);
        } else {
            $stmt = $koneksi->prepare("SELECT * FROM produk"); // Ambil semua produk jika tidak ada pencarian
        }

        // Eksekusi query
        $stmt->execute();
        $result = $stmt->get_result();

        // Menampilkan hasil pencarian
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()): ?>
                <div class="card">
                    <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['nama']; ?>">
                    <h3><?php echo $row['nama']; ?></h3>
                    <p>Harga: Rp. <?php echo number_format($row['harga']); ?></p>
                    <div class="more">
                        <button class="add-to-cart"><i class="fas fa-shopping-cart" data-name="<?php echo $row['nama']; ?>" data-price="<?php echo $row['harga']; ?>"></i> Tambahkan ke Keranjang</button>
                        <button><i class="fas fa-info-circle"></i> Lihat lebih lanjut</button>
                    </div>
                </div>
            <?php endwhile; 
        } else {
            echo '<p>Tidak ada hasil pencarian.</p>';
        }
        ?>

    </main>

    <section id="about" class="about">
        <h2>About Me</h2>
        <p>Hi! Saya Jahron Dengan NIM 37.</p>
        <button id="bio-popup-btn"> KLIK DISINI !</button>
    </section>

    <div id="popup" class="popup-box">
        <div class="popup-content">
            <p><b>ADA DISKON UP TO 45% LOHH!</b>.</p>
            <button id="close-popup"> TUTUP</button>
        </div>
    </div>

    <footer class="footer">
        <p>&copy;2024 </p>
    </footer>

    <script>
        const searchInput = document.getElementById('search-input');
        const resultsContainer = document.getElementById('search-results'); // Container untuk hasil pencarian
        let timeout = null;

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.trim();

            clearTimeout(timeout);

            if (searchTerm.length > 1) {
                timeout = setTimeout(function() {
                    fetch(`search.php?search=${encodeURIComponent(searchTerm)}`)
                        .then(response => response.text())
                        .then(data => {
                            resultsContainer.innerHTML = data; // Hanya ganti konten hasil pencarian

                            if (!data.trim()) {
                                resultsContainer.innerHTML = '<p>Tidak ada hasil pencarian.</p>';
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }, 300 );

            } else if (searchTerm.length === 0) {
                // Jika input kosong, tampilkan semua produk
                fetch('search.php')
                    .then(response => response.text())
                    .then(data => {
                        resultsContainer.innerHTML = data; // Tampilkan semua produk
                    })
                    .catch(error => console.error('Error:', error));
            }
        });

        const addtocartbuttons = document.querySelectorAll('.add-to-cart');

        addtocartbuttons.forEach(button => {
            button.addEventListener('click', function(){
                const name = this.querySelector('.fas').getAttribute('data-name');
                const price = this.querySelector('.fas').getAttribute('data-price');

                let cart = JSON.parse(localStorage.getItem('cart')) || [];
                
                const existingProduct = cart.find(item => item.name === name);

                if(existingProduct){
                    existingProduct.quantity+=1;
                } else {
                    cart.push({name: name, price: price, quantity: 1});
                }
                
                localStorage.setItem('cart', JSON.stringify(cart));

                alert(`${name} Telah Ditambah Ke Keranjang!`);
                window.location.href = `tambahkeranjang.php?name=${encodeURIComponent(name)}&price=${encodeURIComponent(price)}`;
            });
        });

        const darkModeToggle = document.getElementById('dark-mode-toggle');
        const body = document.body;

        darkModeToggle.addEventListener('click', function() {
            body.classList.toggle('dark-mode');
        });

        
        const hamburger = document.getElementById('hamburger');
        const navList = document.getElementById('nav-list');

        hamburger.addEventListener('click', function() {
            navList.classList.toggle('show');
        });

        
        const popup = document.getElementById('popup');
        const bioPopupBtn = document.getElementById('bio-popup-btn');
        const closePopup = document.getElementById('close-popup');

        bioPopupBtn.addEventListener('click', function() {
            popup.style.display = 'block';
        });

        closePopup.addEventListener('click', function() {
            popup.style.display = 'none';  
        });  
    </script>

</body>
</html>