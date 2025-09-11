<?php
session_start();
include '../config.php'; // perhatikan: dashboard_user.php ada di folder user

if(!isset($_SESSION['username'])){
    header("Location: ../login.php");
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM products");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - CodeKids</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    body { font-family: Arial, sans-serif; margin:0; padding:0; }
    .navbar { background: #333; color:white; padding:10px 20px; display:flex; align-items:center; }
    .shop-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:20px; margin-top:20px; }
    .product-card { border:1px solid #ddd; border-radius:10px; padding:15px; background:#fff; text-align:center; box-shadow:0 2px 6px rgba(0,0,0,0.1); }
    .product-card img { max-width:100%; height:150px; object-fit:cover; border-radius:8px; }
    .product-card h4 { margin:10px 0 5px; }
    .product-card p { font-size:14px; color:#666; }
    .product-card button { margin-top:10px; padding:8px 14px; background:#4CAF50; color:white; border:none; border-radius:6px; cursor:pointer; }
    .product-card button:hover { background:#45a049; }
  </style>
</head>
<body>

  <!-- Navbar -->
  <div class="navbar">
    <div style="font-family:'Baloo 2', cursive; font-size:20px; font-weight:600;">
      👩‍💻 CodeKids
    </div>
    <div style="margin-left:auto; display:flex; gap:20px; align-items:center;">
      <a href="dashboard_user.php" style="color:white; text-decoration:none;">Home</a>
      <a href="cart.php" style="color:white; text-decoration:none;">Cart</a>
      <span>Hai, <?php echo $_SESSION['username']; ?></span> 
      <a href="../logout.php" class="cta-button cta-login" style="padding:6px 14px;">Logout</a>
    </div>
  </div>

  <!-- Konten -->
  <div class="dashboard-content" style="padding:20px;">
    <h2 style="color:#333;">Welcome, <?php echo $_SESSION['username']; ?> 👋</h2>

    <h3 style="margin-top:30px;">Katalog Produk</h3>
    <div class="shop-grid">
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="product-card">
          <img src="../uploads/<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama']; ?>">
          <h4><?php echo $row['nama']; ?></h4>
          <p><?php echo $row['deskripsi']; ?></p>
          <p><strong>Rp <?php echo number_format($row['harga']); ?></strong></p>
          <form method="POST" action="cart.php">
            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
            <input type="number" name="jumlah" value="1" min="1" style="width:60px;">
            <button type="submit" name="add_to_cart">Tambah ke Keranjang</button>
          </form>
        </div>
      <?php } ?>
    </div>
  </div>
</body>
</html>