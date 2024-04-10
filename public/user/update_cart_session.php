<?php
session_start();

if (isset($_POST['cart'])) {
    $old = $_SESSION['carts'];
    $_SESSION['carts'] = array_merge($old,$_POST['cart']);
    echo "Cart updated successfully!";
} else {
    echo "Error: Cart data not received.";
}
?>
