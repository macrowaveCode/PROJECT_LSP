<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

// ===================== Tambah Produk =====================
if (isset($_POST['add'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $harga = floatval($_POST['harga']);

    // upload gambar
    if(isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0){
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        $target = "uploads/" . basename($gambar);

        if(move_uploaded_file($tmp, $target)){
            $query = "INSERT INTO products (nama, deskripsi, harga, gambar) 
                      VALUES ('$nama', '$deskripsi', $harga, '$gambar')";
            mysqli_query($conn, $query);
            header("Location: kelola_produk.php");
            exit;
        } else {
            $error = "Gagal upload gambar!";
        }
    } else {
        $error = "Silakan pilih gambar!";
    }
}

// ===================== Edit Produk =====================
if (isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $harga = floatval($_POST['harga']);

    // cek apakah admin ingin update gambar
    if(isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0){
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        $target = "uploads/" . basename($gambar);
        move_uploaded_file($tmp, $target);
        $query = "UPDATE products SET nama='$nama', deskripsi='$deskripsi', harga=$harga, gambar='$gambar' WHERE id=$id";
    } else {
        $query = "UPDATE products SET nama='$nama', deskripsi='$deskripsi', harga=$harga WHERE id=$id";
    }

    mysqli_query($conn, $query);
    header("Location: kelola_produk.php");
    exit;
}

// ===================== Hapus Produk =====================
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    // ambil nama file gambar dulu
    $res = mysqli_query($conn, "SELECT gambar FROM products WHERE id=$id");
    $row = mysqli_fetch_assoc($res);
    if($row && file_exists("uploads/".$row['gambar'])){
        unlink("uploads/".$row['gambar']); // hapus file gambar
    }

    mysqli_query($conn, "DELETE FROM products WHERE id=$id");
    header("Location: kelola_produk.php");
    exit;
}

// ===================== Ambil Semua Produk =====================
$result = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");

// ===================== Ambil Produk untuk Edit =====================
$edit_mode = false;
if(isset($_GET['edit_id'])){
    $edit_id = intval($_GET['edit_id']);
    $res_edit = mysqli_query($conn, "SELECT * FROM products WHERE id=$edit_id");
    $edit_product = mysqli_fetch_assoc($res_edit);
    $edit_mode = true;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kelola Produk</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f0f8ff; }
        h2 { color: #007BFF; }
        a { text-decoration: none; color: #007BFF; }
        a:hover { color: #FFA500; text-decoration: underline; }
        .container { max-width: 900px; margin: auto; }
        .form-box, .list-box {
            background: white; padding: 20px; margin-bottom: 20px;
            border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            border-top: 5px solid #FFA500;
        }
        label { font-weight: bold; display: block; margin-top: 10px; color: #007BFF; }
        input[type=text], input[type=number], textarea, input[type=file] {
            width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;
        }
        button {
            background: #FFA500; color: white; border: none; padding: 10px 15px;
            border-radius: 4px; margin-top: 10px; cursor: pointer; font-weight: 600; transition:0.3s;
        }
        button:hover { background: #ff8c00; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #007BFF; color: white; }
        img { border-radius: 6px; }
        .actions a { margin-right: 10px; color: #007BFF; font-weight: 600; }
        .actions a:hover { color: #FFA500; }
        .delete { color: red; }
        .delete:hover { color: darkred; }
    </style>
</head>
<body>
<div class="container">
    <h2>Kelola Produk</h2>
    <a href="dashboard_admin.php">⬅ Kembali ke Dashboard</a>
    <hr>

    <!-- Form Tambah / Edit Produk -->
    <div class="form-box">
        <h3><?php echo $edit_mode ? "Edit Produk" : "Tambah Produk"; ?></h3>
        <form method="POST" enctype="multipart/form-data">
            <?php if($edit_mode){ ?>
                <input type="hidden" name="id" value="<?php echo $edit_product['id']; ?>">
            <?php } ?>
            <label>Nama</label>
            <input type="text" name="nama" value="<?php echo $edit_mode ? $edit_product['nama'] : ""; ?>" required>

            <label>Deskripsi</label>
            <textarea name="deskripsi" required><?php echo $edit_mode ? $edit_product['deskripsi'] : ""; ?></textarea>

            <label>Harga</label>
            <input type="number" name="harga" value="<?php echo $edit_mode ? $edit_product['harga'] : ""; ?>" required>

            <label>Gambar <?php if($edit_mode){ echo "(biarkan kosong jika tidak ingin diganti)"; } ?></label>
            <input type="file" name="gambar" <?php echo $edit_mode ? "" : "required"; ?>>

            <button type="submit" name="<?php echo $edit_mode ? "edit" : "add"; ?>">
                <?php echo $edit_mode ? "Update Produk" : "Tambah Produk"; ?>
            </button>
        </form>
    </div>

    <!-- List Produk -->
    <div class="list-box">
        <h3>Daftar Produk</h3>
        <table>
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
                <td class="actions">
                    <a href="kelola_produk.php?edit_id=<?php echo $row['id']; ?>">Edit</a>
                    <a href="kelola_produk.php?delete=<?php echo $row['id']; ?>" 
                       class="delete" onclick="return confirm('Yakin hapus produk ini?')">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>
</body>
</html>