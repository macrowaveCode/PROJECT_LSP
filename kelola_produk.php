<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

// Tambah produk
if (isset($_POST['add'])) {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];

    // upload gambar
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    move_uploaded_file($tmp, "uploads/".$gambar);

    mysqli_query($conn, "INSERT INTO products (nama,deskripsi,harga,gambar) 
                         VALUES ('$nama','$deskripsi',$harga,'$gambar')");
    header("Location: manage_products.php");
    exit;
}

// Hapus produk
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id=$id");
    header("Location: manage_products.php");
    exit;
}

// Ambil semua produk
$result = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kelola Produk</title>
</head>
<body>
    <h2>Kelola Produk</h2>
    <a href="dashboard_admin.php">⬅ Kembali ke Dashboard</a>
    <hr>

    <h3>Tambah Produk</h3>
    <form method="POST" enctype="multipart/form-data">
        <label>Nama</label><br>
        <input type="text" name="nama" required><br><br>

        <label>Deskripsi</label><br>
        <textarea name="deskripsi" required></textarea><br><br>

        <label>Harga</label><br>
        <input type="number" name="harga" required><br><br>

        <label>Gambar</label><br>
        <input type="file" name="gambar" required><br><br>

        <button type="submit" name="add">Tambah</button>
    </form>

    <hr>
    <h3>Daftar Produk</h3>
    <table border="1" cellpadding="10">
        <tr>
            <th>Gambar</th>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><img src="uploads/<?php echo $row['gambar']; ?>" width="80"></td>
            <td><?php echo $row['nama']; ?></td>
            <td><?php echo $row['deskripsi']; ?></td>
            <td>Rp <?php echo number_format($row['harga']); ?></td>
            <td>
                <a href="edit_product.php?id=<?php echo $row['id']; ?>">Edit</a> | 
                <a href="manage_products.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Yakin hapus produk ini?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
