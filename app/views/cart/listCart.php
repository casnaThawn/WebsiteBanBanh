<?php include_once 'app/views/share/header.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <title>Giỏ hàng</title>
    <style>
        .cart-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .soluong{
            padding: 10px;
        }
        .quantity {
            display: flex;
            align-items: center;
        }
    </style>
</head>

<body>
    <div>
        <h1 style="color:black;">Giỏ hàng</h1>
        <ul style="padding: 20px;">
            <?php
            $totalPrice = 0;
            if (!isset($_COOKIE['cart']) || empty($_COOKIE['cart'])) {
                echo "<p>Giỏ hàng của bạn đang trống!</p>";
            } else {
                $cart = json_decode($_COOKIE['cart'], true);
                foreach ($cart as $productId => $quantity) {
                    $product = $this->productModel->getProductById($productId);
                    if (!empty($product)) {
                        echo "<li style=\"display: grid; align-items: center; margin-bottom: 20px; padding: 20px; border-bottom: 1px solid black; grid-template-columns: repeat(3,35%) ;gap:20px;\">
                                <div><img src=\"/websitecodecake/" . $product->product_image . "\" alt=\"image\" style=\"width: 200px;\"></div>
                                <div style=\"color:black;\">Tên sản phẩm: " . $product->product_name . " - Mô tả: " . $product->product_description . " - Giá: " . $product->product_price . "</div>
                                <div class=\"quantity\">
                                    <button class=\"btn btn-google\" onclick=\"updateQuantity($productId, -1)\">-</button>
                                    <span id=\"quantity-$productId\" class=\"soluong\">$quantity</span>
                                    <button class=\"btn btn-facebook\" onclick=\"updateQuantity($productId, 1)\">+</button>
                                </div>
                                <button style=\"width:200px;\" class=\"btn btn-danger\" onclick=\"removeFromCart($productId)\">Xóa</button>
                              </li>";                        

                        $totalPrice += $product->product_price * $quantity;                        
                    }
                }
                echo "<div class=\"cart-container\">";
                echo "<h2>Tổng tiền: $totalPrice VNĐ</h2>";
                echo "<a href=\"/websitecodecake/product/checkout\" class=\"btn btn-primary btn-icon-split p-3\">Thanh toán</a>";
                echo "</div>";

            }
            ?>
        </ul>
    </div>

    <script>
        function updateQuantity(productId, change) {
            var quantityElement = document.getElementById("quantity-" + productId);
            var quantity = parseInt(quantityElement.innerHTML) + change;
            if (quantity < 0) {
                return;
            }
            quantityElement.innerHTML = quantity;
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/websitecodecake/app/views/cart/update_quantity.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    location.reload();
                }
            };
            xhr.send("productId=" + productId + "&quantity=" + quantity);
        }

        function removeFromCart(productId) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/websitecodecake/app/views/cart/remove_product.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    location.reload();
                }
            };
            xhr.send("productId=" + productId);
        }

    </script>


</body>

</html>

<?php include_once 'app/views/share/footer.php'; ?>