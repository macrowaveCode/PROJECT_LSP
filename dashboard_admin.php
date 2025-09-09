<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial; margin:0; padding:0; }
        .container {
            padding: 30px;
        }
        .box {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 15px 0;
            background: #f9f9f9;
        }
        a { text-decoration: none; display: inline-block; padding: 10px; background: #333; color: #fff; border-radius: 5px; }
        a:hover { background: #555; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <div class="box">
            <h3>Kelola Produk</h3>
            <p><a href="manage_products.php">Masuk ke halaman kelola produk</a></p>
        </div>
        <div class="box">
            <h3>Kelola Transaksi</h3>
            <p><a href="manage_transactions.php">Masuk ke halaman kelola transaksi</a></p>
        </div>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
