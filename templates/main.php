<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>

        <ul class="promo__list">
            <?php foreach ($categories as $category): ?>
            <li class="promo__item promo__item--<?= $category['title_id'] ?> ">
                <a class="promo__link" href="pages/all-lots.html"><?= htmlspecialchars($category['title']) ?></a>
            </li>
            <?php endforeach; ?>
        </ul>

    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>

        <ul class="lots__list">
            <?php foreach ($advertisement as $advertisements): ?>
            <?php [$hour, $minut] = diff_in_time($advertisements['date_end']); ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?= htmlspecialchars($advertisements['img_path']) ?>" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?= htmlspecialchars($advertisements['title']) ?></span>
                    <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= htmlspecialchars($advertisements['id']) ?>"><?= htmlspecialchars($advertisements['name_lot']) ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">
                                Стартовая цена
                            </span>
                            <span class="lot__cost"><?= costs_of_item($advertisements['start_price']) ?></span>
                        </div>
                        <div class="lot__timer timer <?= $hour<1 ? 'timer--finishing' : '' ?>">
                            <?= $hour . ':' . $minut ?>
                        </div>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>
</main>