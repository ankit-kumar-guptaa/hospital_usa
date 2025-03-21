<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);

    // Save to database
    $stmt = $pdo->prepare("INSERT INTO jobseekers (name, email, phone, desired_role, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$name, $email, $phone, $role]);

    // Send email to admin
    $subject = "New Jobseeker Application";
    $body = "<h2>New Jobseeker Application</h2>
             <p><strong>Name:</strong> $name</p>
             <p><strong>Email:</strong> $email</p>
             <p><strong>Phone:</strong> $phone</p>
             <p><strong>Desired Role:</strong> $role</p>";
    $emailResult = sendEmail('theankitkumarg@gmail.com', $subject, $body);

    // Send confirmation email to user
    $userSubject = "Thank You for Applying at HospitalPlacement";
    $userBody = "<h2>Thank You, $name!</h2>
                 <p>We have received your application for the role of <strong>$role</strong>. Our team will get in touch with you soon.</p>
                 <p>Best regards,<br>HospitalPlacement Team</p>";
    sendEmail($email, $userSubject, $userBody);

    echo json_encode(['status' => 'success', 'message' => 'Application submitted successfully!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>