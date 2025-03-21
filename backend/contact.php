<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    // Save to database
    $stmt = $pdo->prepare("INSERT INTO contacts (name, email, message, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$name, $email, $message]);

    // Send email to admin
    $subject = "New Contact Message";
    $body = "<h2>New Contact Message</h2>
             <p><strong>Name:</strong> $name</p>
             <p><strong>Email:</strong> $email</p>
             <p><strong>Message:</strong> $message</p>";
    $emailResult = sendEmail('theankitkumarg@gmail.com', $subject, $body);

    // Send confirmation email to user
    $userSubject = "Thank You for Contacting HospitalPlacement";
    $userBody = "<h2>Thank You, $name!</h2>
                 <p>We have received your message. Our team will respond to you soon.</p>
                 <p>Best regards,<br>HospitalPlacement Team</p>";
    sendEmail($email, $userSubject, $userBody);

    echo json_encode(['status' => 'success', 'message' => 'Message sent successfully!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>