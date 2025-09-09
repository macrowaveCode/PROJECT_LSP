<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $payment_method = $_POST['payment_method'];

    // ambil produk dari cart
    $cart = $conn->query("SELECT cart.product_id, cart.quantity, products.price 
                          FROM cart 
                          JOIN products ON cart.product_id = products.id 
                          WHERE cart.user_id = $user_id");

    $total_price = 0;
    while($row = $cart->fetch_assoc()){
        $total_price += $row['price'] * $row['quantity'];
    }

    // simpan order
    $conn->query("INSERT INTO orders (user_id, payment_method, total_price) 
                  VALUES ($user_id, '$payment_method', $total_price)");
    $order_id = $conn->insert_id;

    // simpan order items
    $cart = $conn->query("SELECT cart.product_id, cart.quantity, products.price 
                          FROM cart 
                          JOIN products ON cart.product_id = products.id 
                          WHERE cart.user_id = $user_id");

    while($row = $cart->fetch_assoc()){
        $pid = $row['product_id'];
        $qty = $row['quantity'];
        $price = $row['price'];
        $conn->query("INSERT INTO order_items (order_id, product_id, quantity, price) 
                      VALUES ($order_id, $pid, $qty, $price)");
    }

    // kosongkan cart
    $conn->query("DELETE FROM cart WHERE user_id = $user_id");

    echo "<h2>Faktur Pembelian</h2>";
    echo "Tanggal: " . date("Y-m-d H:i:s") . "<br>";
    echo "Total Harga: $total_price <br>";
    echo "Metode Pembayaran: $payment_method <br><br>";
    echo "<a href='dashboard.php'>Kembali ke Dashboard</a>";
}
?>
