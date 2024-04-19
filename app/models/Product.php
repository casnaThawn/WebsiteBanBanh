<?php

require_once 'app/models/CategoryModel.php';

class Product {
    public $product_name;
    public $slug;
    public $product_price;
    public $is_special;
    public $product_size;
    public $product_description;
    public $product_image;
    public $product_category;

    public static $SIZE_CHOICE = array(
        array('none', 'none'),
        array('3 cm', '3 cm'),
        array('4 cm', '4 cm'),
        array('5 cm', '5 cm'),
        array('10 cm', '10 cm'),
        array('12 cm', '12 cm'),
        array('18 cm', '18 cm'),
        array('23 cm', '23 cm')
    );

    public function __construct($product_name, $slug, $product_price=0, $is_special=false, $product_size='none', $product_description, $product_image, $product_category) {
        $this->product_name = $product_name;
        $this->slug = $slug;
        $this->product_price = $product_price;
        $this->is_special = $is_special;
        $this->product_size = $product_size;
        $this->product_description = $product_description;
        $this->product_image = $product_image;
        $this->product_category = $product_category;
    }

    public function __toString() {
        return $this->product_name;
    }
}
?>
