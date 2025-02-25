<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    public static $instance;
    private $mail = null;
    public function __construct()
    {
        $mail = new PHPMailer(true);
        // Cấu hình server SMTP
        $mail->isSMTP();
        $mail->Host       = getenv('EMAIL_HOST'); 
        $mail->SMTPAuth   = true;
        $mail->Username   = getenv('EMAIL_USERNAME');   // Thay bằng email thật
        $mail->Password   = getenv('EMAIL_PASSWORD');   // Thay bằng mật khẩu thật
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = getenv('EMAIL_PORT'); 
    }
    public function getInstance()
    {
        if (!isset($this->instance)) {
            self::$instance = new Mailer();
        }
        return self::$instance;
    }
    public static function send($sendFrom, $to, $replyTo, $subject, $body, $altbody = 'This is the body in plain text for non-HTML mail clients')
    {
        try {
            $mailer = self::getInstance();
            // Người gửi
            $mailer->mail->setFrom($sendFrom['address'], $sendFrom['name']);
            $mailer->mail->addAddress($to['address'], $to['name']);
            $mailer->mail->addReplyTo($replyTo['address'], $replyTo['name']);
            // Nội dung email
            $mailer->mail->isHTML(true);
            $mailer->mail->Subject = $subject;
            $mailer->mail->Body    = $body;
            $mailer->mail->AltBody = $altbody;
            $mailer->mail->send();
        }
        catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$e->getMessage()}";
        }
    }
}