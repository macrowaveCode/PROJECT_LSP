<?php
include 'config.php';

if (isset($_POST['register'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $no_hp = $_POST['no_hp'];

    mysqli_query($conn, "INSERT INTO users (nama,email,username,password,no_hp,role) 
                         VALUES ('$nama','$email','$username','$password','$no_hp','user')");

    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register User</h2>
    <form method="POST">
        <label>Nama</label><br>
        <input type="text" name="nama" required><br><br>

        <label>Email</label><br>
        <input type="email" name="email" required><br><br>

        <label>Username</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password</label><br>
        <input type="password" name="password" required><br><br>

        <label>No HP</label><br>
        <input type="text" name="no_hp"><br><br>

        <button type="submit" name="register">Daftar</button>
    </form>
</body>
</html>
