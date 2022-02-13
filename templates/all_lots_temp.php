<div class="container">
<section class="lots">
  <h2>Все лоты в категории <span>«<?= htmlspecialchars($category_title['title']) ?>»</span></h2>
  <ul class="lots__list">
  <?php foreach($lots_items as $key => $value): ?>
    <?php [$hour, $minut] = diff_in_time($value['date_end']); ?>
    <li class="lots__item lot">
      <div class="lot__image">
        <img src="<?= $value['img_path']; ?>" width="350" height="260" alt="<?= htmlspecialchars($value['name_lot']); ?>">
      </div>
      <div class="lot__info">
        <span class="lot__category"><?= htmlspecialchars($value['title']); ?></span>
        <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= htmlspecialchars($value['id']); ?>"><?= htmlspecialchars($value['name_lot']); ?></a></h3>
        <div class="lot__state">
          <div class="lot__rate">
            <span class="lot__amount">Стартовая цена</span>
            <span class="lot__cost"><?= htmlspecialchars($value['start_price']); ?><b class="rub">р</b></span>
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

<?php if(count($pages) > 1 && $lots_items): ?>
<ul class="pagination-list">

  <li class="pagination-item pagination-item-prev">
  <?php if($cur_page > 1): ?>
    <a href="/all_lots.php?page=<?= htmlspecialchars($cur_page - 1) ?>">Назад</a>
  <?php endif; ?>
  </li>

  <?php foreach($pages as $page): ?>
  <li class="pagination-item <?php if($page === $cur_page): ?>pagination-item-active<?php endif; ?>">
    <a href="/all_lots.php?page=<?= htmlspecialchars($page); ?>"><?= $page ?></a>
  </li>
  <?php endforeach; ?>

  <li class="pagination-item pagination-item-next">
    <?php if($cur_page < count($pages)): ?>
    <a href="/all_lots.php?page=<?= htmlspecialchars($cur_page + 1) ?>">Вперед</a>
    <?php endif; ?>
  </li>
</ul>
<?php endif; ?>

</div>