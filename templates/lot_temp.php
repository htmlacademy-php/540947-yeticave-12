<section class="lot-item container"> 
  <h2><?= htmlspecialchars($lot_info['name_lot']) ?></h2>
  <div class="lot-item__content">
    <div class="lot-item__left">
      <div class="lot-item__image">
        <img src="../<?= htmlspecialchars($lot_info['img_path']) ?>" width="730" height="548" alt="<?= htmlspecialchars($lot_info['title_id']) ?>">
      </div>
      <p class="lot-item__category">Категория: <span><?= htmlspecialchars($lot_info['title']) ?></span></p>
      <p class="lot-item__description"><?= htmlspecialchars($lot_info['description_lot']) ?></p>
    </div>
    <div class="lot-item__right">
      <div class="lot-item__state">
      <?php [$hour, $minut] = diff_in_time($lot_info['date_end']); ?>
        <div class="lot-item__timer timer <?= $hour<1 ? 'timer--finishing' : '' ?>">
        <?= $hour . ':' . $minut ?>
        </div>
        <div class="lot-item__cost-state">
          <div class="lot-item__rate">
            <span class="lot-item__amount">Текущая цена</span>
            <span class="lot-item__cost"><?= costs_of_item($lot_info['current_price'] ? $lot_info['current_price'] : $lot_info['start_price'] ) ?></span>
          </div>
          <div class="lot-item__min-cost">
            Мин. ставка <span><?= htmlspecialchars(costs_of_item($min_bet)) ?></span>
          </div>
        </div>
        <?php if(isset($_SESSION['user']) && time() <= strtotime($lot_info['date_end']) && $_SESSION['user']['id'] != $lot_info['users_id'] && !($_SESSION['user']['id'] == $bet_info[0]['users_id'])): ?>
        <form class="lot-item__form" action="lot.php?id=<?= htmlspecialchars($id) ?>" method="post" autocomplete="off">
          <p class="lot-item__form-item form__item <?= !empty($errors) ? 'form__item--invalid' : ''; ?>">
            <label for="cost">Ваша ставка</label>
            <input id="cost" type="text" name="cost" placeholder="<?= htmlspecialchars(costs_of_item($min_bet)); ?>" value="<?= getPostVal('cost') ?>">
            <?php if (!empty($errors['cost'])): ?>
            <span class="form__error"><?= $errors['cost']; ?></span>
            <?php endif; ?>
          </p>
          <button type="submit" class="button">Сделать ставку</button>
        </form>
        <?php endif; ?>
      </div>
      <div class="history">
        <h3>История ставок (<span><?= htmlspecialchars(count($bet_info)) ?></span>)</h3>
        <table class="history__list">
          <?php foreach ($bet_info as $bets): ?>
          <tr class="history__item">
            <td class="history__name"><?= htmlspecialchars($bets['users_name']); ?></td>
            <td class="history__price"><?= htmlspecialchars(costs_of_item($bets['final_price'])); ?></td>
            <td class="history__time"><?= htmlspecialchars(bet_time($bets['dt_add'])); ?></td>
          </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
  </div>
</section>
