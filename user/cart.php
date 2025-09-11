<?php
session_start();
include '../config.php'; // koneksi database

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// ===================== Tambah / Update Cart =====================
if(isset($_POST['add_to_cart'])){
    $product_id = intval($_POST['product_id']);
    $jumlah = intval($_POST['jumlah']);

    // cek apakah produk sudah ada di cart
    $check = mysqli_query($conn, "SELECT * FROM cart WHERE user_id=$user_id AND produk=$product_id");
    if(mysqli_num_rows($check) > 0){
        // update quantity
        mysqli_query($conn, "UPDATE cart SET jumlah = jumlah + $jumlah WHERE user_id=$user_id AND produk=$product_id");
    } else {
        // insert baru
        mysqli_query($conn, "INSERT INTO cart (user_id, produk, jumlah) VALUES ($user_id, $product_id, $jumlah)");
    }
    header("Location: cart.php");
    exit;
}

// ===================== Update quantity =====================
if(isset($_POST['update_cart'])){
    foreach($_POST['quantities'] as $cart_id => $qty){
        $cart_id = intval($cart_id);
        $qty = intval($qty);
        if($qty <= 0){
            mysqli_query($conn, "DELETE FROM cart WHERE id=$cart_id AND user_id=$user_id");
        } else {
            mysqli_query($conn, "UPDATE cart SET jumlah=$qty WHERE id=$cart_id AND user_id=$user_id");
        }
    }
    header("Location: cart.php");
    exit;
}

// ===================== Hapus item =====================
if(isset($_GET['delete'])){
    $cart_id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM cart WHERE id=$cart_id AND user_id=$user_id");
    header("Location: cart.php");
    exit;
}

// ===================== Ambil Data Cart =====================
$result = mysqli_query($conn, "SELECT cart.id AS cart_id, products.id AS product_id, products.nama, products.deskripsi, products.harga, products.gambar, cart.jumlah
                              FROM cart 
                              JOIN products ON cart.produk = products.id
                              WHERE cart.user_id=$user_id");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
    <style>
        body { font-family: Arial, sans-serif; margin:20px; background:#f7f7f7; }
        h2 { color:#333; }
        table { width:100%; border-collapse: collapse; background:white; }
        th, td { padding:12px; border-bottom:1px solid #ddd; text-align:center; }
        th { background:#007BFF; color:white; }
        img { width:80px; border-radius:6px; }
        input[type=number] { width:60px; }
        button { padding:6px 12px; background:#28a745; color:white; border:none; border-radius:4px; cursor:pointer; }
        button:hover { background:#218838; }
        .delete-btn { background:red; }
        .delete-btn:hover { background:#a00; }
        .total { font-weight:bold; font-size:18px; }
        .topnav { margin-bottom:20px; }
        .topnav a { margin-right:20px; text-decoration:none; color:#007BFF; }
        .topnav a:hover { text-decoration:underline; }
    </style>
</head>
<body>
    <div class="topnav">
    <a href="dashboard_user.php">⬅ Kembali ke Home</a>
    <span>Hai, <?php echo $_SESSION['username']; ?></span>
    <a href="../logout.php" onclick="return confirm('Yakin mau keluar?');">Logout</a>
    </div>


    <h2>Keranjang Belanja</h2>

    <form method="POST" action="cart.php">
        <table>
            <tr>
                <th>Gambar</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
            <?php 
            $total = 0;
            while($row = mysqli_fetch_assoc($result)){
                $subtotal = $row['harga'] * $row['jumlah'];
                $total += $subtotal;
            ?>
            <tr>
                <td><img src="../uploads/<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama']; ?>"></td>
                <td><?php echo $row['nama']; ?></td>
                <td>Rp <?php echo number_format($row['harga']); ?></td>
                <td>
                    <input type="number" name="quantities[<?php echo $row['cart_id']; ?>]" value="<?php echo $row['jumlah']; ?>" min="0">
                </td>
                <td>Rp <?php echo number_format($subtotal); ?></td>
                <td>
                    <a href="cart.php?delete=<?php echo $row['cart_id']; ?>" class="delete-btn" onclick="return confirm('Yakin hapus item ini?')">Hapus</a>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="4" class="total">Total</td>
                <td colspan="2" class="total">Rp <?php echo number_format($total); ?></td>
            </tr>
        </table>
        <br>
        <button type="submit" name="update_cart">Update Jumlah</button>
    </form>

    <br>
    <form method="POST" action="checkout.php">
        <label>Pilih Metode Pembayaran:</label>
        <select name="metode_pembayaran" required>
            <option value="transfer">Transfer Bank</option>
            <option value="ewallet">E-Wallet</option>
            <option value="cod">Bayar di Tempat (COD)</option>
        </select>
        <br><br>
        <button type="submit">Checkout</button>
    </form>

</body>
</html>