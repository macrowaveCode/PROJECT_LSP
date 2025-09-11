<?php
session_start();
include 'config.php';
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$order_id = $_GET['order_id'];

$order = mysqli_query($conn, "SELECT * FROM orders WHERE id=$order_id")->fetch_assoc();
$items = mysqli_query($conn, "SELECT oi.*, p.name FROM order_items oi 
                              JOIN products p ON oi.product_id=p.id 
                              WHERE order_id=$order_id");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Struk - CodeKids</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="dashboard-content">
    <h2>Struk Pembelian</h2>
    <p><strong>Order ID:</strong> <?php echo $order['id']; ?></p>
    <p><strong>Tanggal:</strong> <?php echo $order['created_at']; ?></p>
    <table border="1" cellpadding="8" cellspacing="0">
      <tr><th>Produk</th><th>Qty</th><th>Harga</th><th>Subtotal</th></tr>
      <?php $total=0; while($row = mysqli_fetch_assoc($items)) { 
        $sub = $row['price'] * $row['quantity']; $total+=$sub; ?>
        <tr>
          <td><?php echo $row['name']; ?></td>
          <td><?php echo $row['quantity']; ?></td>
          <td>Rp <?php echo number_format($row['price'],0,',','.'); ?></td>
          <td>Rp <?php echo number_format($sub,0,',','.'); ?></td>
        </tr>
      <?php } ?>
    </table>
    <h3>Total: Rp <?php echo number_format($total,0,',','.'); ?></h3>
    <a href="dashboard_user.php">⬅ Kembali ke Dashboard</a>
  </div>
</body>
</html>
