<?php
require __DIR__ . '/vendor/autoload.php';

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

// DB
$mysqli = new mysqli("localhost", "root", "", "miniproject_db");
if ($mysqli->connect_error) {
    die("DB connection failed: " . $mysqli->connect_error);
}

// VAPID keys (use yours)
$publicKey  = "BKaW6Jlt2OD-8UNwXq_zxsP4f7zmb6JGFHxKnoEohfqAbnAB_ya--HxEmiBBv0722jDngJic1XnlUjC2y8U6cgI";
$privateKey = "HlEeoMKp17_ipDrnSHE7bsOD18yrZ_ugX79myV99pQc";

// Payload
$payload = json_encode([
    "title" => "Special Offer!",
    "body"  => "20% off on electronics you rated highly!",
    "icon"  => "/images/offer.png",
    "url"   => "http://localhost/miniproject/offers/electronics"
]);

// WebPush
$webPush = new WebPush([
    "VAPID" => [
        "subject"    => "mailto:admin@yourdomain.com",
        "publicKey"  => $publicKey,
        "privateKey" => $privateKey,
    ],
]);

// Fetch subscriptions
$result = $mysqli->query("SELECT endpoint, p256dh, auth FROM subscriptions");
if (!$result) {
    die("Query error: " . $mysqli->error);
}

while ($row = $result->fetch_assoc()) {
    $subscription = Subscription::create([
        "endpoint" => $row['endpoint'],
        "keys" => [
            "p256dh" => $row['p256dh'],
            "auth"   => $row['auth']
        ],
    ]);

    $report = $webPush->sendOneNotification($subscription, $payload);

    if ($report->isSuccess()) {
        echo "Sent to {$report->getEndpoint()}<br>";
    } else {
        echo "Failed: {$report->getReason()}<br>";
    }
}

$mysqli->close();