<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

$orders = $conn->query("SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_date DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Pesanan</title>
</head>
<body>
    <h2>Riwayat Pesanan Anda</h2>
    <table border="1">
        <tr>
            <th>Tanggal</th>
            <th>Total Harga</th>
            <th>Metode Pembayaran</th>
        </tr>
        <?php while($row = $orders->fetch_assoc()){ ?>
            <tr>
                <td><?php echo $row['order_date']; ?></td>
                <td><?php echo $row['total_price']; ?></td>
                <td><?php echo $row['payment_method']; ?></td>
            </tr>
        <?php } ?>
    </table>
    <br><a href="dashboard.php">Kembali</a>
</body>
</html>
