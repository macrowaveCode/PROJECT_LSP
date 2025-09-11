<?php
$host = "127.0.0.1";   // bisa juga "localhost"
$port = 8889;          // default MAMP
$user = "root";
$pass = "root";        // default MAMP
$db   = "jwp_ecom";

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
