<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
$produk = mysqli_fetch_assoc($result);

// Update produk
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];

    if ($_FILES['gambar']['name']) {
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        move_uploaded_file($tmp, "uploads/".$gambar);

        mysqli_query($conn, "UPDATE products SET nama='$nama',deskripsi='$deskripsi',harga=$harga,gambar='$gambar' WHERE id=$id");
    } else {
        mysqli_query($conn, "UPDATE products SET nama='$nama',deskripsi='$deskripsi',harga=$harga WHERE id=$id");
    }

    header("Location: manage_products.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk</title>
</head>
<body>
    <h2>Edit Produk</h2>
    <a href="manage_products.php">⬅ Kembali</a>
    <form method="POST" enctype="multipart/form-data">
        <label>Nama</label><br>
        <input type="text" name="nama" value="<?php echo $produk['nama']; ?>" required><br><br>

        <label>Deskripsi</label><br>
        <textarea name="deskripsi" required><?php echo $produk['deskripsi']; ?></textarea><br><br>

        <label>Harga</label><br>
        <input type="number" name="harga" value="<?php echo $produk['harga']; ?>" required><br><br>

        <label>Gambar</label><br>
        <input type="file" name="gambar"><br><br>
        <img src="uploads/<?php echo $produk['gambar']; ?>" width="120"><br><br>

        <button type="submit" name="update">Update</button>
    </form>
</body>
</html>
