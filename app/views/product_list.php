<?php
include_once 'app/views/share/header.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Danh sách sản phẩm</title>
</head>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<body>
    <div>
    <a href="/websitecodecake/product/viewCart" style="font-size:25px; position: absolute; right: 100px; color:black;">Cart <i class='bx bx-cart-alt'></i></a>
    </div>

    <div>
        <h1 style="color:black;">Danh sách sản phẩm</h1>    
        <ul style="padding: 20px;">
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <li style="display: grid; align-items: center; margin-bottom: 20px; padding: 20px; border-bottom: 1px solid black; grid-template-columns: repeat(3,35%) ;gap:20px;">
                <div style="color:black;">
                    <?php echo $row['product_name'] . " - " . $row['product_description'] . " - " . $row['product_price']; ?>
                </div>
                <div>
                    <img src="/websitecodecake/<?php echo $row['product_image']; ?>" alt="image" style="width: 300px;">
                </div>
                <div>
                    <form action="/websitecodecake/product/addToCart/<?php echo $row['id']; ?>" method="post">
                        <input type="submit" value="ADD TO CART">
                    </form>
                </div>
            </li>
        <?php endwhile; ?>
        </ul>
    </div>
    
</body>
</html>

<?php
include_once 'app/views/share/footer.php';
?>