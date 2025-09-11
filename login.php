<?php
session_start();
include "config.php";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // sebaiknya pakai password_hash untuk real project

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $_SESSION['id']       = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role']     = $row['role']; // ✅ pakai "=" bukan "=="

        if ($row['role'] == 'admin') {
            header("Location: dashboard_admin.php");
            exit;
        } else {
            header("Location: dashboard_user.php");
            exit;
        }
    } else {
        echo "<script>alert('Username atau Password salah!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    <form method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" name="login">Login</button>
    </form>
    <p>Belum punya akun? <a href="register.php">Daftar</a></p>
    <p><a href="index.php">⬅ Kembali ke Home</a></p>
  </div>
</body>
</html>
