<?php
class OrderModel{
    private $conn;
    private $table_name = "order_detail";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function MaxOrder() {
        $query = "SELECT MAX(id) as max_id FROM `order`";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['max_id'];
    }

    public function MaxId() {
        $query = "SELECT MAX(id) as max_id FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['max_id'];
    }

    public function MaxIdOrder() {
        $query = "SELECT MAX(id_order) as max_id FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['max_id'];
    }

    function createOrder($id, $fullname, $phone, $address, $total, $date){
        $errors = [];
        if (empty($fullname)) {
            $errors['fullname'] = 'Ngày lập đơn hàng không được để trống';
        }
        if (empty($phone)) {
            $errors['phone'] = 'Ngày lập đơn hàng không được để trống';
        }
        if (empty($address)) {
            $errors['address'] = 'Ngày lập đơn hàng không được để trống';
        }
        if (empty($date)) {
            $errors['date'] = 'Ngày lập đơn hàng không được để trống';
        }
        if (!is_numeric($total) || $total < 0) {
            $errors['total'] = 'Tổng giá đơn hàng không hợp lệ';
        }
        $total=intval($total);

        if (count($errors) > 0) {
            return $errors;
        }

        // Truy vấn tạo sản phẩm mới

        $query = "INSERT INTO `order` (id, fullname, phone, address, total, date) VALUES (:id, :fullname, :phone, :address, :total, :date)";
        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $id = htmlspecialchars(strip_tags($id));
        $fullname = htmlspecialchars(strip_tags($fullname));
        $address = htmlspecialchars(strip_tags($address));
        $total = htmlspecialchars(strip_tags($total));
        $date = htmlspecialchars(strip_tags($date));
        $phone = htmlspecialchars(strip_tags($phone));

        // Gán dữ liệu vào câu lệnh
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':phone', $phone);

        echo $id, $fullname, $phone, $address, $total, $date;
        
        // Thực thi câu lệnh
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function createOrderDetail($id, $name, $price, $amount, $id_order){
        $errors = [];
        if (empty($name)) {
            $errors['product_name'] = 'Tên sản phẩm không được để trống';
        }
        if (!is_numeric($price) || $price < 0) {
            $errors['product_price'] = 'Giá sản phẩm không hợp lệ';
        }
        if (!is_numeric($amount) || $amount < 0) {
            $errors['product_amount'] = 'Số lượng phẩm không hợp lệ';
        }
        
        $total=intval($price)*intval($amount);
        if (!is_numeric($total) || $total < 0) {
            $errors['product_total'] = 'Tổng giá sản phẩm không hợp lệ';
        }

        if (count($errors) > 0) {
            return $errors;
        }

        // Truy vấn tạo sản phẩm mới

        $query = "INSERT INTO " . $this->table_name . " (id, product_name, product_price, product_amount, product_total, id_order) VALUES (:id, :product_name, :product_price, :product_amount, :product_total, :id_order)";
        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $id = htmlspecialchars(strip_tags($id));
        $name = htmlspecialchars(strip_tags($name));
        $amount = htmlspecialchars(strip_tags($amount));
        $price = htmlspecialchars(strip_tags($price));
        $total = htmlspecialchars(strip_tags($total));
        $id_order = htmlspecialchars(strip_tags($id_order));

        // Gán dữ liệu vào câu lệnh
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':product_name', $name);
        $stmt->bindParam(':product_amount', $amount);
        $stmt->bindParam(':product_price', $price);
        $stmt->bindParam(':product_total', $total);
        $stmt->bindParam(':id_order', $id_order);

        // Thực thi câu lệnh
        if ($stmt->execute()) {
            return true;
        }

        return false;


    }

}

?>