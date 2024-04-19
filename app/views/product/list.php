<!DOCTYPE html>
<html>
<head>
    <title>Danh sách sản phẩm</title>
</head>
<style>
    th, td {
        border: 1px solid black;
        padding: 10px 20px;
    }

    td a {
        color: black;
        text-decoration: none;
    }

    td a:hover {
        color: red;       
        /*text-decoration: underline;  */
    }

    td a:hover::after {
        content: '';
        width: 70px;        
        border: 1px solid red;
        border-radius: 20px;
        margin-top: 20px;
        margin-left: -75px;
        position: absolute; 
    }

</style>
<body>
    <h1>Danh sách sản phẩm</h1>
    
    <div class="products-container" style="text-align:center;">
        <!-- Categories -->
        <div class="categories">
            <label for="cars">Choose a category:</label>
            <select name="cars" id="cars">
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>                
                <option value="<?php echo $row['category_name']; ?>"><?php echo $row['category_name']; ?></option>
            <?php endwhile; ?>
            </select>
        </div>
        <!-- Products -->
        <div class="products">
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Product Description</th>
                        <th>Product Size</th>
                        <th>Product Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['product_description']; ?></td>
                        <td><?php echo $row['product_size']; ?></td>
                        <td><?php echo $row['product_price']; ?></td>
                        <td><a href="">ADD CART</a></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>        
    </div>
</body>
</html>