<?php
define('BOT_TOKEN', 'PUT_YOUR_BOT_TOKEN');
define('ADMIN_ID', '123456789');
define('BONUS_AMOUNT', 0.05);
define('BONUS_TIMER', 3600);

$db = new PDO("sqlite:" . __DIR__ . "/database/database.sqlite");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
