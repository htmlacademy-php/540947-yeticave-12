<?php
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

$sql = $mysqli->query("SELECT l.id lot_id, l.name_lot, u.users_name, u.email users_email, b.users_id last_bet_user
            FROM lot l
                JOIN bet b ON l.id = b.lot_id
                JOIN users u ON b.users_id = u.id
            WHERE l.winner_id IS NULL AND l.date_end <= NOW() AND b.final_price = (SELECT MAX(b.final_price) FROM bet b WHERE b.lot_id = l.id)");

$result = $sql->fetch_all(MYSQLI_ASSOC);

if ($result) {
    $winner_update = "UPDATE lot
                SET winner_id = ?
                WHERE id = ?";
    
    foreach ($result as $lot => $value) {
        $stmt = db_get_prepare_stmt($mysqli, $winner_update, [$value['last_bet_user'], $value['lot_id']]);
        $stmt->execute();

        $email_content = include_template('email.php', ['message' => $value]);

        // Конфигурация траспорта
        $dsn = 'smtp://3372bf7402040b:730f8e52f4c01a@smtp.mailtrap.io:2525?encryption=tls&auth_mode=login';
        $transport = Transport::fromDsn($dsn);

        // Формирование сообщения
        $message = new Email();
        $message->to($value['users_email']);
        $message->from("keks@phpdemo.ru");
        $message->subject("Ваша ставка победила");
        //$message->html($email_content);
        $message->text("Поздравляем с победой. Перейдите в \"мои ставки\",чтобы связаться с автором объявления");
        // Отправка сообщения
        $mailer = new Mailer($transport);
        $mailer->send($message);
    }
}