<?php
/**
 * @Author: Your name
 * @Date:   2024-11-08 19:36:24
 * @Last Modified by:   Your name
 * @Last Modified time: 2024-11-08 20:37:48
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy giá trị của reCAPTCHA từ form
    $recaptcha_response = $_POST['g-recaptcha-response'];

    // Kiểm tra nếu người dùng không hoàn thành reCAPTCHA
    if (empty($recaptcha_response)) {
        die('Please complete the reCAPTCHA');
    }

    // Xác thực với Google
    $secret_key = "6LdV93gqAAAAALao9ScJ2eyvH3aRZdpqgu72xQp8";  // Thay bằng Secret Key của bạn
    $verify_url = "https://www.google.com/recaptcha/api/siteverify";
    
    // Khởi tạo cURL để gửi yêu cầu xác thực
    $response = file_get_contents($verify_url . "?secret=" . $secret_key . "&response=" . $recaptcha_response);
    $response_keys = json_decode($response, true);
    
    // Kiểm tra kết quả
    if (intval($response_keys["success"]) !== 1) {
        die('reCAPTCHA verification failed, please try again.');
    } else {
        // Xử lý đăng nhập
        echo "reCAPTCHA verified successfully!";
        // Tiến hành xác thực người dùng từ cơ sở dữ liệu...
    }
}
?>
