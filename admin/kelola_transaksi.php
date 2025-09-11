<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

// Ambil semua transaksi terbaru (join dengan users)
$query = "
    SELECT o.id AS order_id, u.username, u.nama, o.tgl_pesanan, o.metode_pembayaran, o.total_harga
    FROM orders o
    JOIN users u ON o.user_id = u.id
    ORDER BY o.tgl_pesanan DESC
";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kelola Transaksi</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f7f7f7; }
        h2 { color: #333; }
        a { text-decoration: none; color: #007BFF; }
        a:hover { text-decoration: underline; }
        .container { max-width: 1000px; margin: auto; }
        table { width: 100%; border-collapse: collapse; background: white; margin-top: 20px; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background: #007BFF; color: white; }
        button { background: #28a745; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; }
        button:hover { background: #218838; }
        .topnav { margin-bottom: 20px; }
        .topnav a { margin-right: 20px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Kelola Transaksi</h2>
    <div class="topnav">
        <a href="dashboard_admin.php">⬅ Kembali ke Dashboard</a>
    </div>

    <table>
        <tr>
            <th>ID Transaksi</th>
            <th>User</th>
            <th>Tanggal</th>
            <th>Total Harga</th>
            <th>Metode Pembayaran</th>
            <th>Aksi</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['order_id']; ?></td>
            <td><?php echo $row['nama'] . " (" . $row['username'] . ")"; ?></td>
            <td><?php echo $row['tgl_pesanan']; ?></td>
            <td>Rp <?php echo number_format($row['total_harga']); ?></td>
            <td><?php echo $row['metode_pembayaran']; ?></td>
            <td>
                <a href="invoice_admin.php?order_id=<?php echo $row['order_id']; ?>" target="_blank">
                    <button>Lihat Faktur</button>
                </a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>