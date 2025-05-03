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
        $this->mail = new PHPMailer(true);
        // Cấu hình server SMTP
        $this->mail->isSMTP();
        $this->mail->Host       = getenv('EMAIL_HOST'); 
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = getenv('EMAIL_USERNAME');   // Thay bằng email thật
        $this->mail->Password   = getenv('EMAIL_PASSWORD');   // Thay bằng mật khẩu thật
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port       = getenv('EMAIL_PORT'); 
    }
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Mailer();
        }
        return self::$instance;
    }
    public static function send($sendFrom, $to, $replyTo, $subject, $body, $altbody = 'This is the body in plain text for non-HTML mail clients')
    {
        try {
            $mailer = self::getInstance();
            // Người gửi
            // echo $sendFrom['address'];
            // echo $sendFrom['name'];
            // Người nhận
            // echo $to['address'];
            // echo $to['name'];
            // Người nhận phản hồi
            // echo $replyTo['address'];
            // echo $replyTo['name'];
            // Gửi email
            // echo $subject;
            // echo $body;
            // echo $altbody;
            $mailer->mail->setFrom($sendFrom['address'], $sendFrom['name']);
            $mailer->mail->addAddress($to['address'], $to['name']);
            $mailer->mail->addReplyTo($replyTo['address'], $replyTo['name']);       
            // Nội dung email
            $mailer->mail->isHTML(true);
            $mailer->mail->Subject = $subject;
            $mailer->mail->Body    = $body;
            $mailer->mail->AltBody = $altbody;
            $mailer->mail->send();
            // echo '<pre>'.print_r($mailer->mail, true).'</pre>';
            return [
                'success' => true,
                'message' => 'Message has been sent',
            ];
        }
        catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Message could not be sent. Mailer Error: ' . $e->getMessage(),
            ];
        }
    }
}