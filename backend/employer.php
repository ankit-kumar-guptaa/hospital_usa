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

    // Send email to admin with CC (Creative Design)
    $subject = "USA New Employer Request";
    $body = "
    <html>
    <body style='font-family: Helvetica, Arial, sans-serif; margin: 0; padding: 0; background-color: #f0f2f5;'>
        <table width='100%' cellpadding='0' cellspacing='0' style='max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 15px; overflow: hidden; border: 1px solid #e0e0e0;'>
            <tr>
                <td style='background: linear-gradient(135deg, #ff6f61, #ff9f1c); padding: 25px; text-align: center;'>
                    <h2 style='color: #ffffff; margin: 0; font-size: 26px; text-transform: uppercase; letter-spacing: 1px;'>New Employer Request</h2>
                    <p style='color: #ffffff; font-size: 14px; margin: 5px 0 0;'>From US Website</p>
                </td>
            </tr>
            <tr>
                <td style='padding: 30px;'>
                    <p style='color: #444; font-size: 16px; line-height: 1.5;'>Hello Team,</p>
                    <p style='color: #444; font-size: 16px; line-height: 1.5;'>A new employer has reached out to us. Check out the details below:</p>
                    <table width='100%' cellpadding='10' style='background-color: #fff8f0; border-left: 4px solid #ff6f61; margin: 15px 0;'>
                        <tr>
                            <td style='font-weight: bold; color: #ff6f61;'>Company:</td>
                            <td style='color: #444;'>$company</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold; color: #ff6f61;'>Email:</td>
                            <td style='color: #444;'>$email</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold; color: #ff6f61;'>Phone:</td>
                            <td style='color: #444;'>$phone</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold; color: #ff6f61;'>Role Needed:</td>
                            <td style='color: #444;'>$role</td>
                        </tr>
                    </table>
                    <p style='color: #444; font-size: 16px; line-height: 1.5;'>Let’s connect with them soon!</p>
                </td>
            </tr>
            <tr>
                <td style='background-color: #ff9f1c; padding: 15px; text-align: center;'>
                    <p style='color: #ffffff; font-size: 14px; margin: 0; font-style: italic;'>HospitalPlacement | Building Bridges for Talent</p>
                </td>
            </tr>
        </table>
    </body>
    </html>";
    $emailResult = sendEmail('rajiv@elitecorporatesolutions.com', $subject, $body, 'palak@hospitalplacement.com');

    // Send confirmation email to user (Creative Design)
    $userSubject = "Thank You for Your Request at HospitalPlacement";
    $userBody = "
    <html>
    <body style='font-family: Helvetica, Arial, sans-serif; margin: 0; padding: 0; background-color: #f0f2f5;'>
        <table width='100%' cellpadding='0' cellspacing='0' style='max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 15px; overflow: hidden; border: 1px solid #e0e0e0;'>
            <tr>
                <td style='background: linear-gradient(135deg, #2ecc71, #27ae60); padding: 25px; text-align: center;'>
                    <h2 style='color: #ffffff; margin: 0; font-size: 26px;'>Thank You, $company!</h2>
                    <p style='color: #ffffff; font-size: 14px; margin: 5px 0 0;'>We’ve Got Your Request!</p>
                </td>
            </tr>
            <tr>
                <td style='padding: 30px;'>
                    <p style='color: #444; font-size: 16px; line-height: 1.5;'>Hello from HospitalPlacement,</p>
                    <p style='color: #444; font-size: 16px; line-height: 1.5;'>We’re excited to confirm that we’ve received your request for the role of <strong>$role</strong>. Here’s what you submitted:</p>
                    <p style='color: #444; font-size: 16px; line-height: 1.5;'><strong>Company:</strong> $company<br><strong>Phone:</strong> $phone</p>
                    <p style='color: #444; font-size: 16px; line-height: 1.5; margin-top: 20px;'>Our team will reach out to you soon to discuss next steps.</p>
                </td>
            </tr>
            <tr>
                <td style='background-color: #27ae60; padding: 15px; text-align: center;'>
                    <p style='color: #ffffff; font-size: 14px; margin: 0; font-style: italic;'>HospitalPlacement | Your Partner in Recruitment</p>
                </td>
            </tr>
        </table>
    </body>
    </html>";
    $userEmailResult = sendEmail($email, $userSubject, $userBody);

    // Check email sending status
    if ($emailResult === true && $userEmailResult === true) {
        echo json_encode(['status' => 'success', 'message' => 'Request submitted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Request submitted, but email sending failed.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>