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

    // Send email to admin with CC (Super Attractive Design)
    $subject = "USA New Jobseeker Application";
    $body = "
    <html>
    <body style='font-family: Poppins, Arial, sans-serif; margin: 0; padding: 0; background-color: #f1f5f9;'>
        <table width='100%' cellpadding='0' cellspacing='0' style='max-width: 650px; margin: 30px auto; background-color: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.15);'>
            <tr>
                <td style='background: linear-gradient(120deg, #4f46e5, #7c3aed); padding: 30px; text-align: center; position: relative;'>
                    <h2 style='color: #ffffff; margin: 0; font-size: 28px; font-weight: 600; letter-spacing: 1px;'>New Jobseeker Alert!</h2>
                    <p style='color: #e0e7ff; font-size: 16px; margin: 8px 0 0;'>Fresh Application from US Website</p>
                    <div style='position: absolute; bottom: -20px; left: 50%; transform: translateX(-50%); width: 40px; height: 40px; background-color: #ffffff; border-radius: 50%;'></div>
                </td>
            </tr>
            <tr>
                <td style='padding: 40px 30px;'>
                    <p style='color: #1e293b; font-size: 16px; line-height: 1.6; margin: 0 0 20px;'>Hey Team,</p>
                    <p style='color: #1e293b; font-size: 16px; line-height: 1.6; margin: 0 0 20px;'>We’ve got a new jobseeker on board! Check out their details below:</p>
                    <table width='100%' cellpadding='12' style='background: linear-gradient(135deg, #f8fafc, #e2e8f0); border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);'>
                        <tr>
                            <td style='font-weight: 600; color: #4f46e5; width: 30%;'>Name</td>
                            <td style='color: #1e293b;'>$name</td>
                        </tr>
                        <tr>
                            <td style='font-weight: 600; color: #4f46e5;'>Email</td>
                            <td style='color: #1e293b;'>$email</td>
                        </tr>
                        <tr>
                            <td style='font-weight: 600; color: #4f46e5;'>Phone</td>
                            <td style='color: #1e293b;'>$phone</td>
                        </tr>
                        <tr>
                            <td style='font-weight: 600; color: #4f46e5;'>Desired Role</td>
                            <td style='color: #1e293b;'>$role</td>
                        </tr>
                    </table>
                    <p style='color: #1e293b; font-size: 16px; line-height: 1.6; margin: 20px 0 0;'>Let’s make their career dreams a reality!</p>
                </td>
            </tr>
            <tr>
                <td style='background-color: #7c3aed; padding: 20px; text-align: center;'>
                    <p style='color: #ffffff; font-size: 14px; margin: 0; font-weight: 500;'>HospitalPlacement | Crafting Futures, One Job at a Time</p>
                </td>
            </tr>
        </table>
    </body>
    </html>";
    $emailResult = sendEmail('rajiv@elitecorporatesolutions.com', $subject, $body, 'palak@hospitalplacement.com');

    // Send confirmation email to user (Super Attractive Design)
    $userSubject = "Thank You for Applying at HospitalPlacement";
    $userBody = "
    <html>
    <body style='font-family: Poppins, Arial, sans-serif; margin: 0; padding: 0; background-color: #f1f5f9;'>
        <table width='100%' cellpadding='0' cellspacing='0' style='max-width: 650px; margin: 30px auto; background-color: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.15);'>
            <tr>
                <td style='background: linear-gradient(120deg, #ec4899, #f43f5e); padding: 30px; text-align: center; position: relative;'>
                    <h2 style='color: #ffffff; margin: 0; font-size: 28px; font-weight: 600; letter-spacing: 1px;'>Welcome Aboard, $name!</h2>
                    <p style='color: #fee2e2; font-size: 16px; margin: 8px 0 0;'>Your Application is In!</p>
                    <div style='position: absolute; bottom: -20px; left: 50%; transform: translateX(-50%); width: 40px; height: 40px; background-color: #ffffff; border-radius: 50%;'></div>
                </td>
            </tr>
            <tr>
                <td style='padding: 40px 30px;'>
                    <p style='color: #1e293b; font-size: 16px; line-height: 1.6; margin: 0 0 20px;'>Hi $name,</p>
                    <p style='color: #1e293b; font-size: 16px; line-height: 1.6; margin: 0 0 20px;'>We’re super excited to confirm that your application for <strong>$role</strong> has been received! Here’s what we’ve noted:</p>
                    <table width='100%' cellpadding='12' style='background: linear-gradient(135deg, #fef2f2, #fee2e2); border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);'>
                        <tr>
                            <td style='font-weight: 600; color: #ec4899; width: 30%;'>Email</td>
                            <td style='color: #1e293b;'>$email</td>
                        </tr>
                        <tr>
                            <td style='font-weight: 600; color: #ec4899;'>Phone</td>
                            <td style='color: #1e293b;'>$phone</td>
                        </tr>
                        <tr>
                            <td style='font-weight: 600; color: #ec4899;'>Role</td>
                            <td style='color: #1e293b;'>$role</td>
                        </tr>
                    </table>
                    <p style='color: #1e293b; font-size: 16px; line-height: 1.6; margin: 20px 0 0;'>Hang tight—our team will reach out soon with the next steps!</p>
                </td>
            </tr>
            <tr>
                <td style='background-color: #f43f5e; padding: 20px; text-align: center;'>
                    <p style='color: #ffffff; font-size: 14px; margin: 0; font-weight: 500;'>HospitalPlacement | Where Your Career Takes Flight</p>
                </td>
            </tr>
        </table>
    </body>
    </html>";
    $userEmailResult = sendEmail($email, $userSubject, $userBody);

    // Check email sending status
    if ($emailResult === true && $userEmailResult === true) {
        echo json_encode(['status' => 'success', 'message' => 'Application submitted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Application submitted, but email sending failed.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>