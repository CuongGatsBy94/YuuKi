<?php
// Mã bảo mật của Google reCAPTCHA
$secretKey = '6LdV93gqAAAAALao9ScJ2eyvH3aRZdpqgu72xQp8';
$recaptchaResponse = $_POST['g-recaptcha-response'];

// Kiểm tra nếu người dùng đã gửi reCAPTCHA
if(!$recaptchaResponse) {
    die("reCAPTCHA verification failed. Please try again.");
}

// Kiểm tra reCAPTCHA với Google
$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$recaptchaResponse");
$responseKeys = json_decode($response, true);

if(intval($responseKeys['success']) !== 1) {
    die("reCAPTCHA verification failed. Please try again.");
} else {
    // Nếu reCAPTCHA hợp lệ, tiếp tục xử lý đăng nhập
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Tiến hành xác thực email và password với cơ sở dữ liệu của bạn ở đây...
    // Ví dụ:
    // $db = new mysqli('localhost', 'root', '', 'your_database');
    // $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    // $result = $db->query($query);
    
    // Xử lý đăng nhập nếu xác thực thành công
}
?>
