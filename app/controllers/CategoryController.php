<?php

require_once 'app/models/CategoryModel.php';

class CategoryController {
    public function listCategories() {
        $database = new Database();
        $db = $database->getConnection();

        $category = new CategoryModel($db);
        $stmt = $category->readAll();

        include_once 'app/views/product_list.php';
    }
}