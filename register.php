<?php
include "config.php";

if (isset($_POST['register'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); // untuk project nyata, pakai password_hash
    $no_hp = $_POST['no_hp'];

    $query = "INSERT INTO users (nama,email,username,password,no_hp,role)
              VALUES ('$nama','$email','$username','$password','$no_hp','user')";
    mysqli_query($conn, $query);

    echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="login-container"> <!-- pakai container sama seperti login -->
    <h2>Daftar Akun</h2>
    <form method="POST">
      <input type="text" name="nama" placeholder="Nama Lengkap" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="text" name="no_hp" placeholder="No HP" required>
      <button type="submit" name="register">Daftar</button>
    </form>
    <p>Sudah punya akun? <a href="login.php">Login</a></p>
    <p><a href="index.php">⬅ Kembali ke Home</a></p>
  </div>
</body>
</html>