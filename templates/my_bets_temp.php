<nav class="nav">
  <ul class="nav__list container">
        <?php foreach ($categories as $category): ?>
    <li class="nav__item">
      <a href="all-lots.html"><?= htmlspecialchars($category['title']) ?></a>
    </li>
        <?php endforeach; ?>
  </ul>
</nav>
    <section class="rates container">
      <h2>Мои ставки</h2>
      <table class="rates__list">
        <?php foreach($my_bet_info as $bet_info): ?>
        <?php [$hour, $minut] = diff_in_time($bet_info['date_end']); ?>
        <tr class="rates__item <?= (time() > strtotime($bet_info['date_end']) && $bet_info['winner_id'] == $id) ? 'rates__item--win' : ''; ?> <?= (time() > strtotime($bet_info['date_end']) && $bet_info['winner_id'] !== $id) ? 'rates__item--end' : ''; ?>"> <!-- rates__item--win  rates__item--end-->
          <td class="rates__info">
            <div class="rates__img">
                <img src="<?= htmlspecialchars($bet_info['img_path']) ?>" width="54" height="40" alt="<?= htmlspecialchars($bet_info['title']) ?>">
            </div>
            <h3 class="rates__title"><a href="lot.php?id=<?= htmlspecialchars($bet_info['id']) ?>"><?= htmlspecialchars($bet_info['name_lot']) ?></a></h3>
            <?php if($bet_info['winner_id'] == $id): ?>
            <p><?= htmlspecialchars($bet_info['contacts']) ?></p>
            <?php endif; ?>
          </td>
          <td class="rates__category">
            <?= htmlspecialchars($bet_info['title']) ?>
          </td>
          <!-- Вывод результатов ставок -->
          <?php if (time() > strtotime($bet_info['date_end']) && $bet_info['winner_id'] == $id): ?>
            <td class="rates__timer">
            <div class="timer timer--win">Ставка выиграла</div>
          </td>
          <?php elseif(time() > strtotime($bet_info['date_end']) && $bet_info['winner_id'] !== $id): ?>
            <td class="rates__timer">
            <div class="timer timer--end">Торги окончены</div>
          </td>
          <?php else: ?>
          <td class="rates__timer">
            <div class="timer <?= $hour < 1 ? 'timer--finishing' : ''?>"><?= $hour . ':' . $minut ?></div>
          </td>
          <?php endif; ?>
          <td class="rates__price">
            <?= htmlspecialchars(costs_of_item($bet_info['final_price'])) ?>
          </td>
          <td class="rates__time">
            <?= htmlspecialchars(bet_time($bet_info['dt_add'])) ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </table>
    </section>