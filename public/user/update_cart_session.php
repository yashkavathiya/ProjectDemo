<?php
session_start();

if (isset($_POST['cart'])) {
    if($_SESSION['cart']){
        $old = $_SESSION['cart'];
        $_SESSION['carts'] = array_merge($old,$_POST['cart']);
    }else{
        $_SESSION['carts'] = $_POST['cart'];
    }
    echo "Cart updated successfully!";
} else {
    echo "Error: Cart data not received.";
}
?>
