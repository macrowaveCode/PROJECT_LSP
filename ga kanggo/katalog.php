<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: index.php");
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM products");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Katalog Produk</title>
    <style>
        body { font-family: Arial; }
        .product {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px;
            display: inline-block;
            width: 200px;
            text-align: center;
        }
        img { max-width: 100%; height: 120px; }
        button { padding: 5px 10px; margin-top: 5px; }
    </style>
</head>
<body>
    <h2>Katalog Produk</h2>
    <a href="dashboard_user.php">⬅ Back to Dashboard</a>
    <div>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="product">
                <img src="uploads/<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama']; ?>"><br>
                <strong><?php echo $row['nama']; ?></strong><br>
                <p><?php echo $row['deskripsi']; ?></p>
                <p>Rp <?php echo number_format($row['harga']); ?></p>
                <form method="POST" action="cart.php">
                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                    <input type="number" name="jumlah" value="1" min="1" style="width:60px;">
                    <button type="submit" name="add_to_cart">Tambah ke Keranjang</button>
                </form>
            </div>
        <?php } ?>
    </div>
</body>
</html>
