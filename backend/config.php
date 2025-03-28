<?php
// Database Configuration
$host = 'localhost';
$dbname = 'hospital_placement';
$username = 'root'; // Replace with your DB username
$password = ''; // Replace with your DB password


// $host = 'localhost:3306';
// $dbname = 'recru2l1_us_hospital';
// $username = 'recru2l1_root'; // Replace with your DB username
// $password = 'ankit1925'; // Replace with your DB password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// PHPMailer Configuration
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function sendEmail($to, $subject, $body, $cc = null) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'rajiv@greencarcarpool.com';
        $mail->Password = 'Rajiv@111@';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('rajiv@greencarcarpool.com', 'HospitalPlacement');
        $mail->addAddress($to);
        if ($cc) {
            $mail->addCC($cc); // CC email add karne ke liye
        }

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Error logging for debugging
        file_put_contents('email_error.log', "Email failed to: $to - Error: {$mail->ErrorInfo}\n", FILE_APPEND);
        return "Email could not be sent. Error: {$mail->ErrorInfo}";
    }
}
?>