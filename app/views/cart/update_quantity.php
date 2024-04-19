<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productId']) && isset($_POST['quantity'])) {
    $productId = $_POST['productId'];
    $quantity = $_POST['quantity'];
    
    if (isset($_COOKIE['cart'])) {
        $cart = json_decode($_COOKIE['cart'], true);
        
        // Nếu số lượng là 0, xóa sản phẩm khỏi giỏ hàng
        if ($quantity == 0) {
            unset($cart[$productId]);
        } else {
            // Cập nhật số lượng sản phẩm trong giỏ hàng
            $cart[$productId] = $quantity;
        }

        // Lưu giỏ hàng vào cookie
        setcookie('cart', json_encode($cart), time() + (86400 * 30), "/");
        echo "success";
    } else {
        http_response_code(400);
        echo "Invalid request";
    }
}

