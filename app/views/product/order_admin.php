<?php include_once 'app/views/share/header.php'; ?>

<div class="container">
    <h1>List of All Orders</h1>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($order->id); ?></td>
                    <td><?php echo htmlspecialchars($order->customer_name); ?></td>
                    <td><?php echo htmlspecialchars($order->customer_email); ?></td>
                    <td><?php echo htmlspecialchars($order->customer_address); ?></td>
                    <td><?php echo htmlspecialchars($order->customer_phone); ?></td>
                    <td><?php echo htmlspecialchars($order->total_price); ?> VNĐ</td>
                    <td><a href="/websitecodecake/product/detailOrder?orderId=<?php echo $order->id; ?>">Details</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include_once 'app/views/share/footer.php'; ?>
<style>
    body {
        font-family: Arial, sans-serif;
    }

    .container {
        width: 90%;
        margin: 20px auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }
</style>