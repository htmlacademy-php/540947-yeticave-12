<h1>Поздравляем с победой</h1>
<p>Здравствуйте, <?= htmlspecialchars($message['users_name']); ?></p>
<p>Ваша ставка для лота 
    <a href="yeticave13/lot.php?id=<?= htmlspecialchars($message['lot_id']); ?>"><?= htmlspecialchars($message['name_lot']); ?></a> победила.</p>
<p>Перейдите по ссылке 
    <a href="yeticave13/my_bets.php">мои ставки</a>,чтобы связаться с автором объявления</p>
<small>Интернет-Аукцион "YetiCave"</small>