<?php
require_once 'app/models/OrderModel.php';
require_once 'app/models/ProductModel.php';

class OrderController{
    private $orderModel;
    private $db;
    private $productModel;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->orderModel = new OrderModel($this->db);
        $this->productModel = new ProductModel($this->db);
    }

    public function checkout()
    {
        //lưu sản phẩm vào CSDL, kèm upload hình ảnh lên thư mục uploads/ của server
        //cập nhật tên đường dẫn hình ảnh vào cột image của bảng Product
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $product_ids = $_POST['product_id'] ?? array();
            $quantities = $_POST['quantity'] ?? array();
            $total_price = $_POST['total_price'] ?? '';
            $fullname = $_POST['fullname'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';

            $idOrder = $this->orderModel->MaxIdOrder();
            if(!$idOrder)
                $idOrder=1;
            else
                $idOrder+=1;

            $orderMax = $this->orderModel->MaxOrder();
            if(!$orderMax)
                $orderMax=1;
            else
                $orderMax+=1;

            $currentDateTime = new DateTime();
            $date = $currentDateTime->format('Y-m-d H:i:s');
                    
            
            $result = $this->orderModel->createOrder($orderMax, $fullname, $phone, $address, $total_price, $date);

            // Lặp qua mảng $product_ids và $quantities để lấy từng giá trị tương ứng
            foreach ($product_ids as $index => $product_id) {
                // Lấy ID sản phẩm và số lượng tương ứng từ mảng
                $product_id = $product_ids[$index];
                $quantity = $quantities[$index];

                // Tiến hành xử lý dữ liệu ở đây, ví dụ:
                echo "Sản phẩm có ID $product_id có số lượng là $quantity <br>";

                $product = $this->productModel->getProductById($product_id); 

                //lưu đơn hàng
                $id = $this->orderModel->MaxID();
                if(!$id)
                    $id=1;
                else
                    $id+=1; 

                // thêm đơn hàng
                $result = $this->orderModel->createOrderDetail($id, $product->product_name, $product->product_price, $quantity, $idOrder);

                
            }

            if (is_array($result)) {
                // Có lỗi, hiển thị lại form với thông báo lỗi
                $errors = $result;
                include_once 'app/views/cart/listCart.php';
            } else {
                // Không có lỗi, chuyển hướng ve trang chu hoac trang danh sach
                setcookie('cart', '', time() - 3600, '/'); // Xóa cookie cart
                header('Location: /websitecodecake/product/listProducts');
            }
            /*
            if (isset($_POST['id'])) {
                //update
                $id = $_POST['id'];
            }        
            */

            
        }
    }

}

?>