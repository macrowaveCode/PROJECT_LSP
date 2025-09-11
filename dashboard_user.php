<?php
session_start();
include 'config.php';

// cek apakah sudah login dan role user
if(!isset($_SESSION['id']) || $_SESSION['role'] != 'user'){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['id'];
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard User</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<!-- Navbar -->
<div class="navbar">
  <a href="#home">Home</a>
  <a href="#shop">Shop Now</a>
  <a href="#cart">Cart</a>
  <a href="#riwayat">Riwayat</a>
  <span style="margin-left:auto;">Hai, <?php echo $username; ?> | <a href="logout.php">Logout</a></span>
</div>

<!-- Home Section -->
<section id="home" class="dashboard-content">
  <h2>Welcome, <?php echo $username; ?>!</h2>
  <div class="event-box">
    <strong>Info Event:</strong> Lomba coding anak-anak tingkat Surabaya bulan ini!
  </div>
</section>

<!-- Shop Now Section -->
<section id="shop" class="dashboard-content">
  <h2>Katalog Modul</h2>
  <div class="shop-grid">
    <?php
    $produk = mysqli_query($conn, "SELECT * FROM products");
    while($p = mysqli_fetch_assoc($produk)){
        echo "<div class='product-card'>
                <img src='assets/produk/".$p['gambar']."' alt='".$p['nama']."'>
                <h3>".$p['nama']."</h3>
                <p>".$p['deskripsi']."</p>
                <p>Rp ".number_format($p['harga'])."</p>
                <form action='cart_add.php' method='POST'>
                  <input type='hidden' name='product_id' value='".$p['id']."'>
                  <input type='number' name='jumlah' value='1' min='1'>
                  <button type='submit'>Add to Cart</button>
                </form>
              </div>";
    }
    ?>
  </div>
</section>

<!-- Cart Section -->
<section id="cart" class="dashboard-content">
  <h2>Keranjang</h2>
  <?php
  $cart = mysqli_query($conn, "SELECT c.jumlah, p.nama, p.harga 
                               FROM cart c JOIN products p ON c.product_id=p.id 
                               WHERE c.user_id=$user_id");
  if(mysqli_num_rows($cart)==0){
    echo "<p>Keranjang kosong</p>";
  } else {
    echo "<table>
            <tr><th>Produk</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th></tr>";
    $total = 0;
    while($c=mysqli_fetch_assoc($cart)){
        $subtotal = $c['jumlah'] * $c['harga'];
        $total += $subtotal;
        echo "<tr>
                <td>".$c['nama']."</td>
                <td>Rp ".number_format($c['harga'])."</td>
                <td>".$c['jumlah']."</td>
                <td>Rp ".number_format($subtotal)."</td>
              </tr>";
    }
    echo "<tr><td colspan='3'>Total</td><td>Rp ".number_format($total)."</td></tr></table>";
    echo "<a href='checkout.php'><button>Checkout</button></a>";
  }
  ?>
</section>

<!-- Riwayat Section -->
<section id="riwayat" class="dashboard-content">
  <h2>Riwayat Transaksi</h2>
  <!-- nanti bisa pakai kode riwayat yang sudah kamu buat -->
</section>

</body>
</html>
