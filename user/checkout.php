<?php
session_start();
include '../config.php'; // koneksi database

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $payment_method = $_POST['metode_pembayaran'];

    // ambil produk dari cart
    $cart = mysqli_query($conn, "SELECT cart.id AS cart_id, products.id AS product_id, products.nama, products.harga, products.gambar, cart.jumlah
                                 FROM cart 
                                 JOIN products ON cart.produk = products.id 
                                 WHERE cart.user_id = $user_id");

    $total_price = 0;
    $order_items = [];
    while($row = mysqli_fetch_assoc($cart)){
        $subtotal = $row['harga'] * $row['jumlah'];
        $total_price += $subtotal;
        $order_items[] = $row;
    }

    if(count($order_items) == 0){
        echo "<h2>Keranjang kosong!</h2>";
        echo "<a href='dashboard_user.php'>Kembali ke Dashboard</a>";
        exit;
    }

    // simpan order
    mysqli_query($conn, "INSERT INTO orders (user_id, metode_pembayaran, total_harga, tgl_pesanan) 
                         VALUES ($user_id, '$payment_method', $total_price, NOW())");
    $order_id = mysqli_insert_id($conn);

    // simpan order items
    foreach($order_items as $item){
        mysqli_query($conn, "INSERT INTO order_items (order_id, produk, jumlah, harga)
                             VALUES ($order_id, {$item['product_id']}, {$item['jumlah']}, {$item['harga']})");
    }

    // kosongkan cart
    mysqli_query($conn, "DELETE FROM cart WHERE user_id = $user_id");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Checkout - Faktur Pesanan</title>
<style>
    body { font-family: Arial, sans-serif; margin:20px; background:#f7f7f7; }
    h2, h3 { color:#333; }
    .container { max-width: 900px; margin:auto; }
    .order-info { background:white; padding:15px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); margin-bottom:20px; }
    .products { display:flex; flex-direction:column; gap:15px; margin-bottom:20px; }
    .product-card { display:flex; gap:15px; background:white; padding:15px; border-radius:8px; box-shadow:0 1px 4px rgba(0,0,0,0.1); align-items:center; }
    .product-card img { width:80px; height:80px; object-fit:cover; border-radius:6px; }
    .product-details { flex:1; }
    .product-details h4 { margin:0 0 5px; }
    .product-details p { margin:2px 0; color:#555; }
    .subtotal { font-weight:bold; }
    .total-section { text-align:right; margin-top:20px; font-size:18px; font-weight:bold; }
    .btn { display:inline-block; padding:10px 15px; background:#28a745; color:white; border-radius:5px; text-decoration:none; margin-top:20px; }
    .btn:hover { background:#218838; }
</style>
</head>
<body>
<div class="container">
    <h2>✅ Terima Kasih! Pesanan Anda Telah Dikonfirmasi</h2>

    <div class="order-info">
        <p><strong>Tanggal Pesanan:</strong> <?php echo date("Y-m-d H:i:s"); ?></p>
        <p><strong>Metode Pembayaran:</strong> <?php echo $payment_method; ?></p>
    </div>

    <h3>Detail Pesanan</h3>
    <div class="products">
        <?php foreach($order_items as $item){ 
            $subtotal = $item['harga'] * $item['jumlah'];
        ?>
        <div class="product-card">
            <img src="../uploads/<?php echo $item['gambar']; ?>" alt="<?php echo $item['nama']; ?>">
            <div class="product-details">
                <h4><?php echo $item['nama']; ?></h4>
                <p>Harga: Rp <?php echo number_format($item['harga']); ?></p>
                <p>Jumlah: <?php echo $item['jumlah']; ?></p>
            </div>
            <div class="subtotal">
                Rp <?php echo number_format($subtotal); ?>
            </div>
        </div>
        <?php } ?>
    </div>

    <div class="total-section">
        Total Pesanan: Rp <?php echo number_format($total_price); ?>
    </div>

    <a href="dashboard_user.php" class="btn">Kembali ke Dashboard</a>
    <a href="invoice.php?order_id=<?php echo $order_id; ?>" class="btn" style="background:#007BFF;">Faktur</a>
</div>
</body>
</html>
<?php
} else {
    header("Location: cart.php");
    exit;
}
?>