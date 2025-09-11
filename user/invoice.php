<?php
session_start();
include '../config.php'; // koneksi database

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if(!isset($_GET['order_id'])){
    echo "Order ID tidak ditemukan!";
    exit;
}

$order_id = intval($_GET['order_id']);

// ambil data order
$order_res = mysqli_query($conn, "SELECT * FROM orders WHERE id=$order_id AND user_id=$user_id");
$order = mysqli_fetch_assoc($order_res);

if(!$order){
    echo "Order tidak ditemukan atau bukan milik Anda!";
    exit;
}

// ambil order items
$items_res = mysqli_query($conn, "SELECT products.nama, order_items.jumlah, order_items.harga 
                                 FROM order_items 
                                 JOIN products ON order_items.produk = products.id 
                                 WHERE order_items.order_id=$order_id");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Faktur Pesanan</title>
<style>
    body { font-family: Arial, sans-serif; margin:20px; background:#f7f7f7; }
    .container { max-width:700px; margin:auto; background:white; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); }
    h2 { color:#333; }
    table { width:100%; border-collapse: collapse; margin-top:15px; }
    th, td { padding:10px; border:1px solid #ddd; text-align:center; }
    th { background:#007BFF; color:white; }
    .total { text-align:right; font-weight:bold; margin-top:15px; font-size:16px; }
    .btn { display:inline-block; padding:10px 15px; background:#28a745; color:white; border-radius:5px; text-decoration:none; margin-top:20px; }
    .btn:hover { background:#218838; }
</style>
</head>
<body>
<div class="container">
    <h2>Faktur Pesanan #<?php echo $order['id']; ?></h2>
    <p><strong>Tanggal:</strong> <?php echo $order['tgl_pesanan']; ?></p>
    <p><strong>Metode Pembayaran:</strong> <?php echo $order['metode_pembayaran']; ?></p>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Subtotal</th>
        </tr>
        <?php
        $no=1;
        $total=0;
        while($item = mysqli_fetch_assoc($items_res)){
            $subtotal = $item['harga'] * $item['jumlah'];
            $total += $subtotal;
            echo "<tr>
                    <td>{$no}</td>
                    <td>{$item['nama']}</td>
                    <td>{$item['jumlah']}</td>
                    <td>Rp ".number_format($item['harga'])."</td>
                    <td>Rp ".number_format($subtotal)."</td>
                  </tr>";
            $no++;
        }
        ?>
    </table>

    <div class="total">Total Harga: Rp <?php echo number_format($total); ?></div>

    <a href="dashboard_user.php" class="btn">Kembali ke Dashboard</a>
</div>
</body>
</html>