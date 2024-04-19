<?php
require_once 'app/models/CategoryModel.php';

class ProductController
{

    private $productModel;
    private $db;

    private $categoryModel;
    private $accountModel;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
        $this->categoryModel = new CategoryModel($this->db);
        $this->accountModel = new AccountModel($this->db);
    }

    public function listProducts()
    {

        $stmt = $this->productModel->readAll();

        include_once 'app/views/product_list.php';
    }

    public function add()
    {
        $categories = $this->categoryModel->readAll();
        include_once 'app/views/product/add.php';
    }

    public function save()
    {
        //lưu sản phẩm vào CSDL, kèm upload hình ảnh lên thư mục uploads/ của server
        //cập nhật tên đường dẫn hình ảnh vào cột image của bảng Product
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category = $_POST['category'] ?? '';

            if (isset($_POST['id'])) {
                //update
                $id = $_POST['id'];
            }

            $uploadResult = false;
            //kiểm tra để lưu hình ảnh
            if (!empty($_FILES["image"]['size'])) {
                //luu hinh
                $uploadResult = $this->uploadImage($_FILES["image"]);
            }

            //lưu sản phẩm
            if (!isset($id)) {
                $id = $this->productModel->MaxID() + 1;
                echo $id . $category;
                // thêm sản phẩm 
                $result = $this->productModel->createProduct($id, $name, $description, $price, $uploadResult, $category);
            } else
                // update sản phẩm 
                $result = $this->productModel->updateProduct($id, $name, $description, $price, $uploadResult, $category);

            if (is_array($result)) {
                // Có lỗi, hiển thị lại form với thông báo lỗi
                $errors = $result;
                include_once 'app/views/product/add.php';
            } else {
                // Không có lỗi, chuyển hướng ve trang chu hoac trang danh sach
                header('Location: /websitecodecake');
            }
        }
    }
    public function placeOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get user input from the form
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $address = $_POST['address'] ?? '';
            $phone = $_POST['phone'] ?? '';

            // Decode the cart items from cookie
            $cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];

            // Calculate total price and gather product details
            $totalPrice = 0;
            $orderDetails = [];
            foreach ($cart as $productId => $quantity) {
                $product = $this->productModel->getProductById($productId);
                if ($product) {
                    $totalPrice += $product->product_price * $quantity;
                    $orderDetails[] = [
                        'product_id' => $productId,
                        'quantity'   => $quantity,
                        'unit_price' => $product->product_price,
                        'total_price' => $product->product_price * $quantity
                    ];
                }
            }

            // Place the order
            $orderId = $this->productModel->createOrder($name, $email, $address, $phone, $totalPrice);

            // If order is successfully placed
            if ($orderId) {
                // Insert order details
                foreach ($orderDetails as $detail) {
                    $this->productModel->createOrderDetail($orderId, $detail['product_id'], $detail['quantity'], $detail['unit_price'], $detail['total_price']);
                }

                // Clear the cart after successful order placement
                setcookie('cart', '', time() - 3600, '/');

                // Redirect to a confirmation page or similar
                header('Location: /websitecodecake/product/listProducts');
                exit;
            } else {
                // Handle error, e.g., show an error message
                echo 'Error placing order.';
            }
        }
    }
    public function detailOrder(){
        $orderId = isset($_GET['orderId']) ? $_GET['orderId'] : die('Order ID not specified.');
        $orderDetails = $this->productModel->getOrderDetailsById($orderId);
        if (!empty($orderDetails)) {
            $customerInfo = (object) [
                'customer_name' => $orderDetails[0]->customer_name,
                'customer_email' => $orderDetails[0]->customer_email,
                'customer_address' => $orderDetails[0]->customer_address,
                'customer_phone' => $orderDetails[0]->customer_phone,
                'total_price' => $orderDetails[0]->total_price,
            ];
        } else {
            die('Order details not found.');
        }
        include_once 'app/views/product/detailOrder.php';
    }
    public function order(){
        $orders = $this->productModel->getAllOrders();
        include_once 'app/views/product/order_admin.php';
    }

    //hàm upload hình ảnh lên thư mục uploads của server
    public function uploadImage($file)
    {
        $targetDirectory = "uploads/";
        $targetFile = $targetDirectory . basename($file["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Kiểm tra xem file có phải là hình ảnh thực sự hay không
        $check = getimagesize($file["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        // Kiểm tra kích thước file
        if ($file["size"] > 1000000) { // Ví dụ: giới hạn 500KB
            $uploadOk = 0;
        }

        // Kiểm tra định dạng file
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $uploadOk = 0;
        }

        // Kiểm tra nếu $uploadOk bằng 0
        if ($uploadOk == 0) {
            return false;
        } else {
            if (move_uploaded_file($file["tmp_name"], $targetFile)) {
                //đường dẫn của file hình
                return $targetFile;
            } else {
                //không upload được hình
                return false;
            }
        }
    }
    public function checkout()
    {
        include_once 'app/views/cart/checkout.php';
    }

    public function edit($id)
    {

        $product = $this->productModel->getProductById($id);

        if (empty($product)) {
            include_once 'app/views/share/not-found.php';
        } else {
            $categories = $this->categoryModel->readAll();
            include_once 'app/views/product/edit.php';
        }
    }

    public function delete($id)
    {
        $product = $this->productModel->getProductById($id);

        if (empty($product)) {
            include_once 'app/views/share/not-found.php';
        } else {
            $delete = $this->productModel->deleteProduct($product->id);
            if ($delete) {
                echo "Xóa sản phẩm thàng công!";
                header('Location: /websitecodecake');
            } else {
                echo "Xóa sản phẩm thất bại!";
                header('Location: /websitecodecake');
            }
        }
    }

    // Xử lý giỏ hàng
    public function addToCart($productId)
    {
        // Lấy thông tin sản phẩm từ cơ sở dữ liệu dựa trên $productId

        // Kiểm tra xem giỏ hàng đã tồn tại hay chưa
        if (!isset($_COOKIE['cart'])) {
            // Nếu giỏ hàng chưa tồn tại, khởi tạo một giỏ hàng mới
            $cart = array();
        } else {
            // Nếu giỏ hàng đã tồn tại, lấy thông tin giỏ hàng từ cookie
            $cart = json_decode($_COOKIE['cart'], true);
        }

        // Thêm sản phẩm vào giỏ hàng
        $cart[$productId] = isset($cart[$productId]) ? $cart[$productId] + 1 : 1;

        // Lưu giỏ hàng vào cookie
        setcookie('cart', json_encode($cart), time() + (86400 * 30), "/"); // 86400 = 1 day

        // Chuyển hướng người dùng đến trang danh sách sản phẩm sau khi thêm vào giỏ hàng
        header("Location: /websitecodecake/product/listProducts");
        exit;
    }

    public function viewCart()
    {
        $stmt = $this->productModel->readAll();
        // Kiểm tra xem giỏ hàng đã tồn tại hay chưa
        if (!isset($_COOKIE['cart'])) {
            // Nếu giỏ hàng chưa tồn tại, hiển thị giỏ hàng trống
            $cart = array();
        } else {
            // Nếu giỏ hàng đã tồn tại, lấy thông tin giỏ hàng từ cookie
            $cart = json_decode($_COOKIE['cart'], true);
        }

        include_once 'app/views/cart/listCart.php';
    }
}
