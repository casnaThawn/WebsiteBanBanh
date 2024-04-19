<?php
include_once 'app/views/share/header.php';
?>

<?php

if (isset($errors)) {
    echo "<ul>";
    foreach ($errors as $err) {
        echo "<li class='text-danger'>$err</li>";
    }
    echo "</ul>";
}

?>

<div class="card-body p-5">
    <form class="user" action="/websitecodecake/product/save" method="post" enctype="multipart/form-data">
        <!-- đang edit cho sản phẩm  -->
        <input type="hidden" name="id" value="<?=$product->id?>">

        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input value="<?= $product->product_name ?>" type="text" class="form-control form-control-user" id="name" name="name" placeholder="Product Name">
            </div>
            <div class="col-sm-6">
                <input value="<?= $product->product_price ?>" type="number" class="form-control form-control-user" id="price" name="price" placeholder="Product Price">
            </div>
        </div>
        <div class="form-group">
            <input value="<?= $product->product_description ?>" type="text" class="form-control form-control-user" id="description" name="description" placeholder="Product Description">
        </div>

        <!-- hien thi hinh anh  -->
        <div class="form-group">
            <?php
            if (empty($product->product_image) || !file_exists($product->product_image)) {
                echo "No Image!";
            } else {
                echo "<img src='/websitecodecake/" . $product->product_image . "' alt='' style='width:300px; height:250px'/>";
            }
            ?>
        </div>

        <div class="form-group">
            <input type="file" class="form-control form-control-user" id="image" name="image">
        </div>

        <!-- chon loai -->
        <div style="display: flex; gap:10px;">
            <h5>Select category:</h3>
            <select class="form-group" id="selectedCategory" name="selectedCategory" aria-label="Default select example">                
                <?php while ($category = $categories->fetch(PDO::FETCH_ASSOC)): ?>                
                    <option value="<?php echo $category['id']; ?>"><?php echo $category['category_name']; ?></option>                    
                <?php endwhile; ?>
            </select>

            <!-- Thêm input ẩn để lưu giá trị được chọn -->
            <input type="hidden" id="category" name="category" value="1">
        </div>        

        <div class="form-group text-center">
            <button class="btn btn-primary btn-icon-split p-3">
                Save product
            </button>
        </div>
    </form>

</div>

<script>
    document.getElementById("selectedCategory").addEventListener("change", function() {
        var selectedValue = this.value;
        // Lấy id của option được chọn và gán vào input ẩn
        var selectedId = this.options[this.selectedIndex].value;
        var selectedValue = parseInt(selectedId);
        document.getElementById("category").value = selectedValue;
    });
</script>


<?php
include_once 'app/views/share/footer.php';
?>