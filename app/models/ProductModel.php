<?php
class ProductModel {
    private $conn;
    private $table_name = "products";

    public function __construct($db) {
        $this->conn = $db;
    }

    function readAll() {
        $query = "SELECT id, product_name, product_slug, product_size, is_special, product_price, product_description, product_image, product_category FROM " . $this->table_name . " ORDER BY product_category ASC";


        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function MaxID() {
        $query = "SELECT MAX(id) as max_id FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['max_id'];
    }
    
    

    function createProduct($id, $name, $description, $price, $uploadResult, $category)
    {        
        // uploadResult: đường dẫn của file hình 
        // uploadResult = false: lỗi upload hình ảnh
        // Kiểm tra ràng buộc đầu vào
        $errors = [];
        if (empty($name)) {
            $errors['product_name'] = 'Tên sản phẩm không được để trống';
        }
        if (empty($description)) {
            $errors['product_description'] = 'Mô tả không được để trống';
        }
        if (!is_numeric($price) || $price < 0) {
            $errors['product_price'] = 'Giá sản phẩm không hợp lệ';
        }

        if (!is_numeric(intval($category))) {
            $errors['product_category'] = 'Loại sản phẩm không hợp lệ';
        }

        if ($uploadResult == false) {
            $errors['product_image'] = 'Vui lòng chọn hình ảnh hợp lệ!';
        }

        if (count($errors) > 0) {
            return $errors;
        }

        // Truy vấn tạo sản phẩm mới

        $query = "INSERT INTO " . $this->table_name . " (id, product_name, product_description, product_price, product_image, product_category) VALUES (:id, :name, :description, :price, :image, :category)";
        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $id = htmlspecialchars(strip_tags($id));
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = htmlspecialchars(strip_tags($price));
        $category = htmlspecialchars(strip_tags($category));

        // Gán dữ liệu vào câu lệnh
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $uploadResult);
        $stmt->bindParam(':category', $category);

        // Thực thi câu lệnh
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
    public function createOrder($name, $email, $address, $phone, $totalPrice) {
        try {
            $sql = "INSERT INTO orders (customer_name, customer_email, customer_address, customer_phone, total_price) VALUES (:name, :email, :address, :phone, :total_price)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':total_price', $totalPrice);

            $stmt->execute();

            // Return the ID of the created order
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            // Optionally handle the exception
            error_log('Error creating order: ' . $e->getMessage());
            return false;
        }
    }
    public function createOrderDetail($orderId, $productId, $quantity, $unitPrice) {
        try {
            $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :unit_price)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':order_id', $orderId);
            $stmt->bindParam(':product_id', $productId);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':unit_price', $unitPrice);

            $stmt->execute();

            // Return true for a successful insert
            return true;
        } catch (PDOException $e) {
            // Optionally handle the exception
            error_log('Error creating order detail: ' . $e->getMessage());
            return false;
        }
    }

    function getProductById($id){

        $query = "SELECT * FROM " . $this->table_name . " where id = $id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    function updateProduct($id, $name, $description, $price, $uploadResult, $category){

        if ($uploadResult) {
            $query = "UPDATE " . $this->table_name . " SET product_name=:name, product_description=:description, product_price=:price, product_image=:image, product_category=:category WHERE id=:id";

        } else {
            $query = "UPDATE " . $this->table_name . " SET product_name=:name, product_description=:description, product_price=:price, product_category=:category WHERE id=:id";

        }

        $stmt = $this->conn->prepare($query);
        // Làm sạch dữ liệu
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = htmlspecialchars(strip_tags($price));
        $category = htmlspecialchars(strip_tags($category));
        // Gán dữ liệu vào câu lệnh
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category', $category);
        if($uploadResult){
            $stmt->bindParam(':image', $uploadResult);
        }
        // Thực thi câu lệnh
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function deleteProduct($id){
        $id = intval($id);
        echo $id;
        if($id){
            $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $id = htmlspecialchars(strip_tags($id));
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if($stmt->execute()){
                return true; // Trả về true nếu xóa thành công
            } else {
                return false; // Trả về false nếu xóa thất bại
            }
        }
        else{
            echo "Null id !!";
        }
    }
    public function getAllOrders() {
        try {
            $sql = "SELECT * FROM orders";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log('Error fetching orders: ' . $e->getMessage());
            return [];
        }
    }
    public function getOrderDetailsById($orderId) {
        try {
            $sql = "SELECT p.product_name, oi.quantity, oi.price as unit_price, 
                    o.customer_name, o.customer_email, o.customer_address, o.customer_phone,
                    (SELECT SUM(quantity * price) FROM order_items WHERE order_id = :orderId) AS total_price
                    FROM order_items oi
                    JOIN products p ON oi.product_id = p.id
                    JOIN orders o ON oi.order_id = o.id
                    WHERE oi.order_id = :orderId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':orderId', $orderId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log('Error fetching order details: ' . $e->getMessage());
            return [];
        }
    }
}