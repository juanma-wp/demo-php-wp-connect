<?php
require 'config.php';

if (!isset($_SESSION['access_token'])) {
    header('Location: index.php');
    exit;
}

// Get user info from WordPress.com API
$apiUrl = 'https://public-api.wordpress.com/rest/v1.1/me';
$headers = [
    'Authorization: Bearer ' . $_SESSION['access_token']
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For testing only
$response = curl_exec($ch);
curl_close($ch);

$user = json_decode($response, true);

if (isset($user['error'])) {
    die('Error fetching user data: ' . $user['message']);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Your WordPress.com Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .profile {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .avatar {
            float: left;
            margin-right: 20px;
            border-radius: 50%;
        }

        .logout-btn {
            background: #cc1818;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin-top: 20px;
        }

        .logout-btn:hover {
            background: #a01313;
        }
    </style>
</head>

<body>
    <h1>Your WordPress.com Profile</h1>

    <div class="profile">
        <?php if (isset($user['avatar_URL'])): ?>
            <img src="<?= htmlspecialchars($user['avatar_URL']) ?>" class="avatar" width="80" height="80">
        <?php endif; ?>

        <h2><?= htmlspecialchars($user['display_name']) ?></h2>
        <p>Username: <?= htmlspecialchars($user['username']) ?></p>
        <p>Email: <?= htmlspecialchars($user['email']) ?></p>
        <p>Primary Blog: <?= htmlspecialchars($user['primary_blog_url'] ?? 'N/A') ?></p>

        <div style="clear: both;"></div>

        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>

</html>