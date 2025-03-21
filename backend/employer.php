<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company = filter_input(INPUT_POST, 'company', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);

    // Save to database
    $stmt = $pdo->prepare("INSERT INTO employers (company_name, email, phone, role_needed, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$company, $email, $phone, $role]);

    // Send email to admin
    $subject = "New Employer Request";
    $body = "<h2>New Employer Request</h2>
             <p><strong>Company:</strong> $company</p>
             <p><strong>Email:</strong> $email</p>
             <p><strong>Phone:</strong> $phone</p>
             <p><strong>Role Needed:</strong> $role</p>";
    $emailResult = sendEmail('theankitkumarg@gmail.com', $subject, $body);

    // Send confirmation email to user
    $userSubject = "Thank You for Your Request at HospitalPlacement";
    $userBody = "<h2>Thank You!</h2>
                 <p>We have received your request from <strong>$company</strong> for the role of <strong>$role</strong>. Our team will get in touch with you soon.</p>
                 <p>Best regards,<br>HospitalPlacement Team</p>";
    sendEmail($email, $userSubject, $userBody);

    echo json_encode(['status' => 'success', 'message' => 'Request submitted successfully!']);
} else {
    echo json_encode(value: ['status' => 'error', 'message' => 'Invalid request']);
}
?>