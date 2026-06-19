<?php
require __DIR__ . '/vendor/autoload.php';

use Minishlink\WebPush\VAPID;

// Generate new VAPID keys
$keys = VAPID::createVapidKeys();

echo "Public Key: " . $keys['publicKey'] . PHP_EOL;
echo "Private Key: " . $keys['privateKey'] . PHP_EOL;
?>