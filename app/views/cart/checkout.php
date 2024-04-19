<?php include_once 'app/views/share/header.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input,
        textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        .cart-items {
            margin-bottom: 20px;
        }

        .item {
            margin-bottom: 10px;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .summary {
            text-align: right;
            font-size: 16px;
            font-weight: bold;
        }

        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Checkout</h1>
        <div class="cart-items">
            <h2>Your Cart Items</h2>
            <?php
            $totalPrice = 0;
            if (isset($_COOKIE['cart']) && !empty($_COOKIE['cart'])) {
                $cart = json_decode($_COOKIE['cart'], true);
                foreach ($cart as $productId => $quantity) {
                    $product = $this->productModel->getProductById($productId);
                    if (!empty($product)) {
                        echo "<div class='item'>
                                <p><img src=\"/websitecodecake/" . $product->product_image . "\" alt=\"image\" style=\"width: 200px;\"></p>
                                <p><strong>Product:</strong> {$product->product_name}</p>
                                <p><strong>Quantity:</strong> {$quantity}</p>
                                <p><strong>Price:</strong> {$product->product_price} VNĐ</p>
                              </div>";
                        $totalPrice += $product->product_price * $quantity;
                    }
                }
                echo "<p class='summary'>Total: {$totalPrice} VNĐ</p>";
            } else {
                echo "<p>Your cart is empty!</p>";
            }
            ?>
        </div>
        <?php
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $emailuser = $_SESSION['username'] ?? '';

        // Check if the AccountModel is loaded and then proceed
        if (isset($this->accountModel)) {
            $account = $this->accountModel->getAccountByUsername($emailuser);
            $userName = $account->name ?? ''; // Fallback if no name is found
        } else {
            $userName = ''; // Default to empty if model isn't loaded
            $emailuser = ''; // Clear out the email since model is unavailable
            // Handle error or redirect as needed
            echo "Error: Account model is not loaded.";
        }

        ?>
        <form action="/websitecodecake/product/placeOrder" method="POST">
            <h2>Your Information</h2>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($userName); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($emailuser); ?>" required>

            <label for="address">Address:</label>
            <textarea id="address" name="address" required></textarea>

            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" required>

            <button type="submit">Place Order</button>
        </form>
    </div>
</body>

</html>

<?php include_once 'app/views/share/footer.php'; ?>