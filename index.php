<?php
require 'config.php';

// Check if user is already authenticated
if (isset($_SESSION['access_token'])) {
    header('Location: profile.php');
    exit;
}

$authUrl = "https://public-api.wordpress.com/oauth2/authorize?" .
    "client_id=" . WPCOM_CLIENT_ID . "&" .
    "redirect_uri=" . urlencode(WPCOM_REDIRECT_URI) . "&" .
    "response_type=code&" .
    "scope=auth";
?>

<!DOCTYPE html>
<html>

<head>
    <title>WordPress.com Connect Demo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .login-btn {
            background: #0087be;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
        }

        .login-btn:hover {
            background: #006799;
        }
    </style>
</head>

<body>
    <h1>WordPress.com Connect Demo</h1>
    <p>This demo shows how to connect to WordPress.com using OAuth2.</p>
    <a href="<?= htmlspecialchars($authUrl) ?>" class="login-btn">Connect with WordPress.com</a>
</body>

</html>