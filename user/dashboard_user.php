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
    body { font-family: 'Baloo 2', cursive; margin:0; padding:0; background:#f0f8ff; color:#333; }

    /* Navbar */
    .navbar { background: #007BFF; color:white; padding:10px 20px; display:flex; align-items:center; }
    .navbar a { color:white; text-decoration:none; font-weight:600; }
    .navbar a:hover { color:#FFA500; }
    .cta-button { background:#FFA500; color:white; border:none; border-radius:6px; cursor:pointer; padding:6px 14px; font-weight:600; transition:0.3s; }
    .cta-button:hover { background:#ff8c00; }

    /* Grid Produk */
    .shop-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:20px; margin-top:20px; }
    .product-card { border:1px solid #ddd; border-radius:10px; padding:15px; background:white; text-align:center; box-shadow:0 2px 6px rgba(0,0,0,0.1); transition:0.3s; }
    .product-card:hover { transform: translateY(-5px); box-shadow:0 4px 12px rgba(0,0,0,0.15); }
    .product-card img { max-width:100%; height:150px; object-fit:cover; border-radius:8px; }
    .product-card h4 { margin:10px 0 5px; color:#007BFF; }
    .product-card p { font-size:14px; color:#666; }
    .product-card strong { color:#FFA500; font-size:16px; }

    /* Button Tambah ke Keranjang */
    .product-card button { margin-top:10px; padding:8px 14px; background:#007BFF; color:white; border:none; border-radius:6px; cursor:pointer; font-weight:600; transition:0.3s; }
    .product-card button:hover { background:#0056b3; }

    /* Welcome */
    .dashboard-content h2 { color:#007BFF; }
  </style>
</head>
<body>

  <!-- Navbar -->
  <div class="navbar">
    <div style="font-size:20px; font-weight:600;">
      👩‍💻 CodeKids
    </div>
    <div style="margin-left:auto; display:flex; gap:20px; align-items:center;">
      <a href="dashboard_user.php">Home</a>
      <a href="cart.php">Cart</a>
      <span>Hai, <?php echo $_SESSION['username']; ?></span> 
      <a href="../logout.php" class="cta-button">Logout</a>
    </div>
  </div>

  <!-- Konten -->
  <div class="dashboard-content" style="padding:20px;">
    <h2>Welcome, <?php echo $_SESSION['username']; ?> 👋</h2>

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