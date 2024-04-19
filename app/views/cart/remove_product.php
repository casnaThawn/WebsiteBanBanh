<?php

// Kiểm tra xem yêu cầu có phải là POST không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem có tồn tại dữ liệu gửi lên không
    if (isset($_POST["productId"])) {
        // Lấy productId từ dữ liệu gửi lên
        $productId = $_POST["productId"];

        // Xóa sản phẩm khỏi giỏ hàng (ở đây bạn có thể sử dụng bất kỳ cách xóa sản phẩm nào phù hợp với cơ sở dữ liệu của bạn)
        // Ví dụ: nếu bạn lưu giỏ hàng trong cookie, bạn có thể cần xóa sản phẩm khỏi cookie
        // Đảm bảo thực hiện các biện pháp an toàn như kiểm tra quyền truy cập, xác thực người dùng trước khi xóa dữ liệu

        // Ví dụ: Xóa sản phẩm khỏi cookie giỏ hàng
        if (isset($_COOKIE['cart'])) {
            $cart = json_decode($_COOKIE['cart'], true);
            // Kiểm tra xem sản phẩm có tồn tại trong giỏ hàng không
            if (array_key_exists($productId, $cart)) {
                unset($cart[$productId]); // Xóa sản phẩm khỏi giỏ hàng
                // Cập nhật cookie giỏ hàng
                setcookie('cart', json_encode($cart), time() + (86400 * 30), '/'); // Cookie tồn tại trong 30 ngày
            }
        }

        // Trả về kết quả thành công
        echo json_encode(array("success" => true));
    } else {
        // Trả về lỗi nếu không có productId được gửi lên
        echo json_encode(array("success" => false, "message" => "Không tìm thấy productId."));
    }
} else {
    // Trả về lỗi nếu không phải là yêu cầu POST
    echo json_encode(array("success" => false, "message" => "Yêu cầu không hợp lệ."));
}
