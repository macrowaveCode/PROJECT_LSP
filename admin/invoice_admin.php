<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

// pastikan ada order_id
if(!isset($_GET['order_id'])){
    echo "Order tidak ditemukan!";
    exit;
}

$order_id = intval($_GET['order_id']);

// ambil data order
$order_res = mysqli_query($conn, "
    SELECT o.id, o.tgl_pesanan, o.metode_pembayaran, o.total_harga, u.nama, u.username, u.email, u.no_hp
    FROM orders o
    JOIN users u ON o.user_id = u.id
    WHERE o.id = $order_id
");
$order = mysqli_fetch_assoc($order_res);
if(!$order){
    echo "Order tidak ditemukan!";
    exit;
}

// ambil item order
$items_res = mysqli_query($conn, "
    SELECT oi.produk, oi.jumlah, oi.harga, p.nama AS product_name
    FROM order_items oi
    JOIN products p ON oi.produk = p.id
    WHERE oi.order_id = $order_id
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Faktur Transaksi #<?php echo $order['id']; ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin:20px; background:#f7f7f7; }
        .container { max-width: 800px; margin:auto; background:white; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); }
        h2 { text-align:center; }
        table { width:100%; border-collapse: collapse; margin-top:20px; }
        th, td { padding:12px; border-bottom:1px solid #ddd; text-align:left; }
        th { background:#007BFF; color:white; }
        .total { font-weight:bold; font-size:18px; text-align:right; }
        .topnav { margin-bottom:20px; }
        .topnav a { text-decoration:none; color:#007BFF; margin-right:20px; }
        .topnav a:hover { text-decoration:underline; }
    </style>
</head>
<body>
<div class="container">
    <div class="topnav">
        <a href="kelola_transaksi.php">⬅ Kembali ke Daftar Transaksi</a>
    </div>

    <h2>Faktur Transaksi #<?php echo $order['id']; ?></h2>
    <p><strong>Tanggal:</strong> <?php echo $order['tgl_pesanan']; ?></p>
    <p><strong>Nama User:</strong> <?php echo $order['nama'] . " (" . $order['username'] . ")"; ?></p>
    <p><strong>Email:</strong> <?php echo $order['email']; ?></p>
    <p><strong>No HP:</strong> <?php echo $order['no_hp']; ?></p>
    <p><strong>Metode Pembayaran:</strong> <?php echo $order['metode_pembayaran']; ?></p>

    <table>
        <tr>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>
        <?php 
        while($item = mysqli_fetch_assoc($items_res)){
            $subtotal = $item['harga'] * $item['jumlah'];
        ?>
        <tr>
            <td><?php echo $item['product_name']; ?></td>
            <td>Rp <?php echo number_format($item['harga']); ?></td>
            <td><?php echo $item['jumlah']; ?></td>
            <td>Rp <?php echo number_format($subtotal); ?></td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="3" class="total">Total Harga</td>
            <td class="total">Rp <?php echo number_format($order['total_harga']); ?></td>
        </tr>
    </table>
</div>
</body>
</html>