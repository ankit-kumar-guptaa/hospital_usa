<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    // Save to database
    $stmt = $pdo->prepare("INSERT INTO contacts (name, email, message, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$name, $email, $message]);

    // Send email to admin with CC (Attractive Design)
    $subject = "USA New Contact Message";
    $body = "
    <html>
    <body style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;'>
        <table width='100%' cellpadding='0' cellspacing='0' style='max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);'>
            <tr>
                <td style='background-color: #007bff; padding: 20px; text-align: center; border-top-left-radius: 10px; border-top-right-radius: 10px;'>
                    <h2 style='color: #ffffff; margin: 0; font-size: 24px;'>New Contact Message from US Website</h2>
                </td>
            </tr>
            <tr>
                <td style='padding: 30px;'>
                    <p style='color: #333; font-size: 16px; line-height: 1.6;'>Hello Team,</p>
                    <p style='color: #333; font-size: 16px; line-height: 1.6;'>A new message has been received through the HospitalPlacement US website. Here are the details:</p>
                    <table width='100%' cellpadding='10' style='background-color: #f9f9f9; border-radius: 8px; margin-top: 15px;'>
                        <tr>
                            <td style='font-weight: bold; color: #007bff;'>Name:</td>
                            <td style='color: #333;'>$name</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold; color: #007bff;'>Email:</td>
                            <td style='color: #333;'>$email</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold; color: #007bff;'>Message:</td>
                            <td style='color: #333;'>$message</td>
                        </tr>
                    </table>
                    <p style='color: #333; font-size: 16px; line-height: 1.6; margin-top: 20px;'>Please review and respond at your earliest convenience.</p>
                </td>
            </tr>
            <tr>
                <td style='background-color: #007bff; padding: 15px; text-align: center; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;'>
                    <p style='color: #ffffff; font-size: 14px; margin: 0;'>HospitalPlacement Team | Connecting Talent with Opportunity</p>
                </td>
            </tr>
        </table>
    </body>
    </html>";
    $emailResult = sendEmail('rajiv@elitecorporatesolutions.com', $subject, $body, 'palak@hospitalplacement.com');

    // Send confirmation email to user (Attractive Design)
    $userSubject = "Thank You for Contacting HospitalPlacement";
    $userBody = "
    <html>
    <body style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;'>
        <table width='100%' cellpadding='0' cellspacing='0' style='max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);'>
            <tr>
                <td style='background-color: #28a745; padding: 20px; text-align: center; border-top-left-radius: 10px; border-top-right-radius: 10px;'>
                    <h2 style='color: #ffffff; margin: 0; font-size: 24px;'>Thank You, $name!</h2>
                </td>
            </tr>
            <tr>
                <td style='padding: 30px;'>
                    <p style='color: #333; font-size: 16px; line-height: 1.6;'>Dear $name,</p>
                    <p style='color: #333; font-size: 16px; line-height: 1.6;'>We’re delighted to inform you that we’ve received your message! Our team is already on it and will get back to you soon.</p>
                    <p style='color: #333; font-size: 16px; line-height: 1.6;'><strong>Your Message:</strong> $message</p>
                    <p style='color: #333; font-size: 16px; line-height: 1.6; margin-top: 20px;'>Stay tuned for a response from us!</p>
                </td>
            </tr>
            <tr>
                <td style='background-color: #28a745; padding: 15px; text-align: center; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;'>
                    <p style='color: #ffffff; font-size: 14px; margin: 0;'>HospitalPlacement Team | We’re Here to Help</p>
                </td>
            </tr>
        </table>
    </body>
    </html>";
    $userEmailResult = sendEmail($email, $userSubject, $userBody);

    // Check email sending status
    if ($emailResult === true && $userEmailResult === true) {
        echo json_encode(['status' => 'success', 'message' => 'Message sent successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Message submitted, but email sending failed.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>