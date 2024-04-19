<?php
require_once 'app/models/ProductModel.php';
require_once 'app/libs/Auth.php';

class DefaultController{
    private $productModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }
    public function Index() {

        if(!Auth::isAdmin()){
            header('Location: /websitecodecake/account/login');
        }
        
        $products = $this->productModel->readAll();

        include_once 'app/views/share/index.php';
    }
}