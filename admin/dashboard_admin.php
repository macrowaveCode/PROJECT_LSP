<?php
session_start();
include '../config.php'; // perhatikan: admin ada di folder admin

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php"); // atau login.php
    exit;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <style>
    body { font-family: Arial, sans-serif; margin:0; padding:0; background:#f4f4f4; }
    .navbar { background:#333; color:white; padding:10px 20px; display:flex; align-items:center; }
    .navbar a { color:white; text-decoration:none; margin-left:20px; }
    .navbar a:hover { text-decoration:underline; }
    .container { padding:30px; }
    .grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(250px, 1fr)); gap:20px; margin-top:20px; }
    .card { background:white; border-radius:8px; padding:20px; box-shadow:0 2px 6px rgba(0,0,0,0.1); }
    .card h3 { margin:0 0 10px; }
    .btn { display:inline-block; padding:10px 15px; background:#4CAF50; color:white; border-radius:5px; text-decoration:none; }
    .btn:hover { background:#45a049; }
  </style>
</head>
<body>

  <!-- Navbar -->
  <div class="navbar">
    <strong>⚙️ Admin Panel</strong>
    <div style="margin-left:auto;">
      <span>Halo, <?php echo $_SESSION['username']; ?></span>
      <a href="../logout.php">Logout</a>
    </div>
  </div>

  <!-- Konten -->
  <div class="container">
    <h2>Admin Dashboard</h2>
    <div class="grid">
      <div class="card">
        <h3>📦 Kelola Produk</h3>
        <p>Tambah, edit, hapus produk.</p>
        <a href="kelola_produk.php" class="btn">Kelola Produk</a>
      </div>
      <div class="card">
        <h3>💳 Kelola Transaksi</h3>
        <p>Melihat daftar transaksi user.</p>
        <a href="manage_transactions.php" class="btn">Kelola Transaksi</a>
      </div>
    </div>
  </div>

</body>
</html>