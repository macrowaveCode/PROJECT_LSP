<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

// ambil produk dari cart
$result = $conn->query("SELECT cart.id, products.name, products.price, cart.quantity 
                        FROM cart 
                        JOIN products ON cart.product_id = products.id 
                        WHERE cart.user_id = $user_id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
</head>
<body>
    <h2>Your Cart</h2>
    <form method="post" action="checkout.php">
    <table border="1">
        <tr>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>
        <?php
        $total = 0;
        while($row = $result->fetch_assoc()){
            $subtotal = $row['price'] * $row['quantity'];
            $total += $subtotal;
            echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['price']}</td>
                    <td>{$row['quantity']}</td>
                    <td>$subtotal</td>
                </tr>";
        }
        ?>
        <tr>
            <td colspan="3"><b>Total</b></td>
            <td><b><?php echo $total; ?></b></td>
        </tr>
    </table>
    <br>
    <label>Pilih Metode Pembayaran:</label>
    <select name="payment_method">
        <option value="Transfer Bank">Transfer Bank</option>
        <option value="E-Wallet">E-Wallet</option>
        <option value="COD">Bayar di Tempat (COD)</option>
    </select>
    <br><br>
    <input type="submit" value="Checkout">
    </form>
</body>
</html>
