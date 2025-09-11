<?php
include "config.php";

if (isset($_POST['register'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
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
  <title>Register</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Register</h2>
  <form method="POST">
    <input type="text" name="nama" placeholder="Nama Lengkap" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <input type="text" name="no_hp" placeholder="No HP" required><br><br>
    <button type="submit" name="register">Daftar</button>
  </form>
</body>
</html>
