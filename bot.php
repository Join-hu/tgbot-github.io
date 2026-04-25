<?php
require_once 'config.php';
require_once 'functions.php';

$update = json_decode(file_get_contents("php://input"), true);

if (!isset($update['message'])) exit;

$message = $update['message'];
$chat_id = $message['chat']['id'];
$text = trim($message['text'] ?? '');

if (strpos($text, '/start') === 0) {

    $parts = explode(' ', $text);
    $ref = $parts[1] ?? 0;

    $stmt = $db->prepare("SELECT * FROM users WHERE user_id=?");
    $stmt->execute([$chat_id]);

    if (!$stmt->fetch()) {
        $db->prepare("INSERT INTO users(user_id,balance,ref_id,last_bonus) VALUES(?,?,?,?)")
            ->execute([$chat_id, 0, $ref, 0]);

        if ($ref != 0 && $ref != $chat_id) {
            $db->prepare("UPDATE users SET balance = balance + 0.01 WHERE user_id=?")
                ->execute([$ref]);
        }
    }

    sendMessage($chat_id,
"💰 Добро пожаловать в Bonus Bot!

🎁 /bonus - получить бонус
💳 /balance - баланс
👥 /ref - реферальная ссылка");
}

elseif ($text == '/bonus') {

    $stmt = $db->prepare("SELECT * FROM users WHERE user_id=?");
    $stmt->execute([$chat_id]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        sendMessage($chat_id, "Введите /start");
        exit;
    }

    if ((time() - $user['last_bonus']) >= BONUS_TIMER) {

        $db->prepare("UPDATE users SET balance = balance + ?, last_bonus=? WHERE user_id=?")
            ->execute([BONUS_AMOUNT, time(), $chat_id]);

        sendMessage($chat_id, "✅ Бонус начислен: " . BONUS_AMOUNT . " ₽");

    } else {

        $wait = BONUS_TIMER - (time() - $user['last_bonus']);
        sendMessage($chat_id, "⏳ Бонус будет доступен через: {$wait} сек.");
    }
}

elseif ($text == '/balance') {

    $stmt = $db->prepare("SELECT balance FROM users WHERE user_id=?");
    $stmt->execute([$chat_id]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    sendMessage($chat_id, "💳 Баланс: " . ($user['balance'] ?? 0) . " ₽");
}

elseif ($text == '/ref') {

    $link = "https://t.me/YOUR_BOT_USERNAME?start=" . $chat_id;

    sendMessage($chat_id, "👥 Ваша реферальная ссылка:\n" . $link);
}
?>
