<form class="form form--add-lot container <?= !empty($errors) ? 'form--invalid' : ''; ?>" action="add-lot.php" method="post" enctype="multipart/form-data">
  <h2>Добавление лота</h2>
  <div class="form__container-two">
    <div class="form__item <?= !empty($errors['lot-name']) ? 'form__item--invalid' : ''; ?>">
      <label for="lot-name">Наименование <sup>*</sup></label>
      <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?= getPostVal('lot-name'); ?>">
      <?php if (!empty($errors['lot-name'])): ?>
            <span class="form__error"><?= $errors['lot-name']; ?></span>
      <?php endif; ?>
    </div>
    <div class="form__item <?= !empty($errors['category']) ? 'form__item--invalid' : ''; ?>">
      <label for="category">Категория <sup>*</sup></label>
      <select id="category" name="category">
        <option>Выберите категорию</option>
      <?php foreach ($categories as $category): ?>
        <option value="<?= $category['id']; ?>" <?= $category['id'] === getPostVal('category') ? 'selected' : ''; ?>>
        <?= htmlspecialchars($category['title']) ?></option>
      <?php endforeach; ?>
      </select>
      <?php if (!empty($errors['category'])): ?>
            <span class="form__error"><?= $errors['category']; ?></span>
      <?php endif; ?>
    </div>
  </div>
  <div class="form__item form__item--wide <?= !empty($errors['message']) ? 'form__item--invalid' : ''; ?>">
    <label for="message">Описание <sup>*</sup></label>
    <textarea id="message" name="message" placeholder="Напишите описание лота"><?= getPostVal('message'); ?></textarea>
    <?php if (!empty($errors['message'])): ?>
            <span class="form__error"><?= $errors['message']; ?></span>
    <?php endif; ?>
  </div>
  <div class="form__item form__item--file">
    <label>Изображение <sup>*</sup></label>
    <div class="form__input-file <?= !empty($errors['lot-img']) ? 'form__item--invalid' : ''; ?>">
      <input class="visually-hidden" type="file" id="lot-img" name="lot-img" value="">
      <label for="lot-img">
        Добавить
      </label>
      <?php if (!empty($errors['lot-img'])): ?>
            <span class="form__error"><?= $errors['lot-img']; ?></span>
      <?php endif; ?>
    </div>
  </div>
  <div class="form__container-three">
    <div class="form__item form__item--small <?= !empty($errors['lot-rate']) ? 'form__item--invalid' : ''; ?>">
      <label for="lot-rate">Начальная цена <sup>*</sup></label>
      <input id="lot-rate" type="text" name="lot-rate" placeholder="0" value="<?= getPostVal('lot-rate'); ?>">
      <?php if (!empty($errors['lot-rate'])): ?>
            <span class="form__error"><?= $errors['lot-rate']; ?></span>
      <?php endif; ?>
    </div>
    <div class="form__item form__item--small <?= !empty($errors['lot-step']) ? 'form__item--invalid' : ''; ?>">
      <label for="lot-step">Шаг ставки <sup>*</sup></label>
      <input id="lot-step" type="text" name="lot-step" placeholder="0" value="<?= getPostVal('lot-step'); ?>">
      <?php if (!empty($errors['lot-step'])): ?>
            <span class="form__error"><?= $errors['lot-step']; ?></span>
      <?php endif; ?>
    </div>
    <div class="form__item <?= !empty($errors['lot-date']) ? 'form__item--invalid' : ''; ?>">
        <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
        <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?= getPostVal('lot-date'); ?>">
        <?php if (!empty($errors['lot-date'])): ?>
            <span class="form__error"><?= $errors['lot-date']; ?></span>
        <?php endif; ?>
    </div>
  </div>
  <?php if(isset($errors)): ?>
  <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
  <?php endif; ?>
  <button type="submit" class="button">Добавить лот</button>
</form>