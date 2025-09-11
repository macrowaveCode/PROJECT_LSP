<!DOCTYPE html>
<html lang="id">
<head>
  <title>Kursus Coding Anak Surabaya - Trial Gratis di CodeKids Surabaya</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
  <div class="header">
    <img src="assets/logo-codekids.png" alt="Logo" class="logo">
    <div class="action-wrapper">
      <a href="register.php"><button class="cta-button">Register</button></a>
      <a href="login.php"><button class="cta-button cta-login">Login</button></a>
    </div>
  </div>
</header>

<section class="hero">
  <div class="hero-text">
    <h1>Belajar <span class="highlight">Coding Seru</span> Bersama <span class="highlight">CodeKids</span></h1>
    <p>Program belajar coding interaktif untuk anak usia 5–15 tahun.</p>
  </div>
  <div class="hero-image">
    <img src="assets/hero-mascot.png" alt="Maskot">
  </div>
</section>

<!-- Tombol -->
<div class="action-wrapper">
  <button class="cta-button" id="btn-register">Register</button>
  <button class="cta-button cta-login" id="btn-login">Login</button>
</div>

<!-- Modal Login -->
<div id="modal-login" class="modal">
  <div class="modal-content">
    <span class="close" id="close-login">&times;</span>
    <h2>Login</h2>
    <form action="login_process.php" method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" name="login">Login</button>
    </form>
  </div>
</div>

<!-- Modal Register -->
<div id="modal-register" class="modal">
  <div class="modal-content">
    <span class="close" id="close-register">&times;</span>
    <h2>Register</h2>
    <form action="register_process.php" method="POST">
      <input type="text" name="nama" placeholder="Nama Lengkap" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="text" name="no_hp" placeholder="No HP" required>
      <button type="submit" name="register">Daftar</button>
    </form>
  </div>
</div>

<footer>
  <p>© 2025 CodeKids Surabaya</p>
</footer>
</body>
</html>
