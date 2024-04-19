<?php
include_once 'app/views/share/header.php';
?>

<div class="row">

    <a href="/websitecodecake/product/add" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-flag"></i>
        </span>
        <span class="text">Add Product</span>
    </a>
    <a href="/websitecodecake/product/order" class="btn btn-primary btn-icon-split">
        <span class="text">Đơn hàng</span>
    </a>

    <div class="col-sm-12">
        <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Action (Edit/Delete)</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $products->fetch(PDO::FETCH_ASSOC)) : ?>
                    <tr>
                        <th><?= $row['id'] ?></th>
                        <th><?= $row['product_name'] ?></th>
                        <th><?= $row['product_description'] ?></th>
                        <th>

                            <?php
                            if (empty($row['product_image']) || !file_exists($row['product_image'])) {
                                echo "No Image!";
                            } else {
                                echo "<img src='/websitecodecake/" . $row['product_image'] . "' alt='' style='width:250px; height: 200px' />";
                            }
                            ?>

                        </th>
                        <th><?= $row['product_price'] ?></th>
                        <th>
                            <a href="/websitecodecake/product/edit/<?=$row['id']?>">
                                Edit
                            </a>
                            |
                            <a href="/websitecodecake/product/delete/<?=$row['id']?>">
                                Delete
                            </a>                            
                        </th>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>



<?php

include_once 'app/views/share/footer.php';

?>