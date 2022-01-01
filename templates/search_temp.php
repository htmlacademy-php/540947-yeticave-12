<nav class="nav">
    <ul class="nav__list container">
        <?php foreach($categories as $category): ?>
    <li class="nav__item">
        <a href="all-lots.html"><?= htmlspecialchars($category['title']) ?></a>
    </li>
        <?php endforeach; ?>
    </ul>
</nav>
<div class="container">
    <section class="lots">
    <h2>Результаты поиска по запросу «<span><?= htmlspecialchars($search) ?></span>»</h2>
    <ul class="lots__list">
        <?php if(!$lots): ?>
            <span>Ничего не найдено по вашему запросу</span>
        <?php endif; ?>
        <?php foreach($lots as $search_result): ?>
        <li class="lots__item lot">
        <div class="lot__image">
            <img src="<?= $search_result['img_path'] ?>" width="350" height="260" alt="<?= $search_result['name_lot'] ?>">
        </div>
        <div class="lot__info">
            <span class="lot__category"><?= $search_result['title'] ?></span>
            <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= htmlspecialchars($search_result['id']) ?>"><?= $search_result['name_lot'] ?></a></h3>
            <div class="lot__state">
            <div class="lot__rate">
                <span class="lot__amount">Стартовая цена</span>
                <span class="lot__cost"><?= $search_result['start_price'] ?><b class="rub">р</b></span>
            </div>
            <?php [$hour, $minut] = diff_in_time($search_result['date_end']); ?>
            <div class="lot__timer timer <?= $hour<1 ? 'timer--finishing' : '' ?>">
                <?= $hour . ':' . $minut ?>
            </div>
            </div>
        </div>
        </li>
       <?php endforeach; ?>
    </ul>
    </section>
    <?php if(count($pages) > 1 && $lots): ?>
    <ul class="pagination-list">

    <li class="pagination-item pagination-item-prev">
        <?php if($cur_page > 1): ?>
        <a href="/search.php?search=<?= htmlspecialchars($search) ?>&page=<?= htmlspecialchars($cur_page - 1) ?>">Назад</a>
        <?php endif; ?>
    </li>

    <?php foreach($pages as $page): ?>
    <li class="pagination-item <?php if($page == $cur_page): ?>pagination-item-active<?php endif; ?>">
        <a href="/search.php?search=<?= htmlspecialchars($search) ?>&page=<?= htmlspecialchars($page) ?>"><?= $page ?></a>
    </li>
    <?php endforeach; ?>

    <li class="pagination-item pagination-item-next">
        <?php if($cur_page < count($pages)): ?>
        <a href="/search.php?search=<?= htmlspecialchars($search) ?>&page=<?= htmlspecialchars($cur_page + 1) ?>">Вперед</a>
        <?php endif; ?>
    </li>
    </ul>
    <?php endif; ?>
</div>