<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $recipient_email = $_POST["recipient_email"]; // استلام الإيميل من الفورم
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    $mail = new PHPMailer(true);

    try {
        // إعدادات SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'awa*****8@gmail.com'; // حساب المرسل
        $mail->Password   = '********'; // كلمة المرور الخاصة بالتطبيق
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // إعدادات المرسل والمستلم
        $mail->setFrom($email, $fullname);
        $mail->addAddress($recipient_email); // إرسال الإيميل للمستلم المحدد

        // محتوى الإيميل
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "<h3>From: $fullname</h3><h4>Email: $email</h4><p>Message: $message</p>";

        $mail->send();

        $_SESSION['status'] = "Success!";
        $_SESSION['message'] = "Your message has been sent to $recipient_email successfully.";
        $_SESSION['icon'] = "success";
    } catch (Exception $e) {
        $_SESSION['status'] = "Error!";
        $_SESSION['message'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        $_SESSION['icon'] = "error";
    }

    header("Location: contact.php");
    exit();
}
?>
