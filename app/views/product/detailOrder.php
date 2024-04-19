<?php include_once 'app/views/share/header.php'; ?>

<div class="container">
    <h1>Order Details</h1>
    <div class="info-box">
        <h2>Customer Information</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($customerInfo->customer_name); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($customerInfo->customer_email); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($customerInfo->customer_address); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($customerInfo->customer_phone); ?></p>
    </div>
    
    <div class="info-box">
        <h2>Product Details</h2>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price per Unit</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderDetails as $detail) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($detail->product_name); ?></td>
                        <td><?php echo htmlspecialchars($detail->quantity); ?></td>
                        <td><?php echo htmlspecialchars($detail->unit_price); ?> VNĐ</td>
                        <td><?php echo htmlspecialchars($detail->quantity * $detail->unit_price); ?> VNĐ</td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                    <td><strong><?php echo htmlspecialchars($customerInfo->total_price); ?> VNĐ</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php include_once 'app/views/share/footer.php'; ?>

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 0;
}

.container {
    width: 80%;
    margin: 20px auto;
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.info-box {
    background-color: #ffffff;
    border: 1px solid #ddd;
    padding: 15px;
    margin-bottom: 20px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

h1, h2 {
    color: #333;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

</style>
