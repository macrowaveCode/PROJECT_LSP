<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <style>
        body { font-family: Arial; margin:0; padding:0; }
        .navbar {
            background: #333;
            overflow: hidden;
        }
        .navbar a {
            float: left;
            display: block;
            color: #fff;
            padding: 14px 20px;
            text-decoration: none;
        }
        .navbar a:hover {
            background: #575757;
        }
        .content {
            padding: 20px;
        }
        .box {
            border: 1px solid #ccc;
            padding: 15px;
            margin: 10px 0;
            background: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="dashboard_user.php">Home</a>
        <a href="catalog.php">Shop Now</a>
        <a href="cart.php">Cart</a>
        <a href="history.php">Riwayat</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="content">
        <h2>Welcome to User Dashboard 👋</h2>
        <div class="box">
            <h3>📢 Pengumuman Event</h3>
            <p>Ada lomba coding nasional bulan depan! Jangan lupa daftar ya 🚀</p>
        </div>
    </div>
</body>
</html>
