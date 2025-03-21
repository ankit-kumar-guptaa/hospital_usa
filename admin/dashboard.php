<?php
session_start();
require '../backend/config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

// Fetch data
$jobseekers = $pdo->query("SELECT * FROM jobseekers ORDER BY created_at DESC")->fetchAll();
$employers = $pdo->query("SELECT * FROM employers ORDER BY created_at DESC")->fetchAll();
$contacts = $pdo->query("SELECT * FROM contacts ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f4f7fa; }
        h2 { color: #1a2a44; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; background: white; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #0073e6; color: white; }
        tr:hover { background: #f9f9f9; }
        .logout { display: inline-block; margin: 20px 0; padding: 10px 20px; background: #ff6f61; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <h2>Admin Dashboard</h2>
    <a href="logout.php" class="logout">Logout</a>

    <h3>Jobseeker Applications</h3>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Desired Role</th>
            <th>Date</th>
        </tr>
        <?php foreach ($jobseekers as $jobseeker): ?>
            <tr>
                <td><?php echo htmlspecialchars($jobseeker['name']); ?></td>
                <td><?php echo htmlspecialchars($jobseeker['email']); ?></td>
                <td><?php echo htmlspecialchars($jobseeker['phone']); ?></td>
                <td><?php echo htmlspecialchars($jobseeker['desired_role']); ?></td>
                <td><?php echo $jobseeker['created_at']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3>Employer Requests</h3>
    <table>
        <tr>
            <th>Company</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Role Needed</th>
            <th>Date</th>
        </tr>
        <?php foreach ($employers as $employer): ?>
            <tr>
                <td><?php echo htmlspecialchars($employer['company_name']); ?></td>
                <td><?php echo htmlspecialchars($employer['email']); ?></td>
                <td><?php echo htmlspecialchars($employer['phone']); ?></td>
                <td><?php echo htmlspecialchars($employer['role_needed']); ?></td>
                <td><?php echo $employer['created_at']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3>Contact Messages</h3>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Date</th>
        </tr>
        <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?php echo htmlspecialchars($contact['name']); ?></td>
                <td><?php echo htmlspecialchars($contact['email']); ?></td>
                <td><?php echo htmlspecialchars($contact['message']); ?></td>
                <td><?php echo $contact['created_at']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>