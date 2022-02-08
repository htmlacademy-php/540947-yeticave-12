<nav class="nav">
  <ul class="nav__list container">
  <?php foreach($categories as $category):?>
    <li class="nav__item <?php if($category['title'] == $_GET['category_title']): ?>nav__item--current<?php endif; ?>">
      <a href="all_lots.php?category_title=<?= htmlspecialchars($category['title']); ?>"><?= htmlspecialchars($category['title']) ?></a>
    </li>
    <?php endforeach; ?>
  </ul>
</nav>
<form class="form container <?= !empty($errors) ? 'form--invalid' : ''; ?>" action="sign_up.php" method="post" autocomplete="off"> 
  <h2>Регистрация нового аккаунта</h2>
  <div class="form__item <?= !empty($errors['email']) ? 'form__item--invalid' : ''; ?>"> 
    <label for="email">E-mail <sup>*</sup></label>
    <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= getPostVal('email'); ?>">
    <?php if (!empty($errors['email'])): ?>
    <span class="form__error"><?= $errors['email']; ?></span>
    <?php endif; ?>
  </div>
  <div class="form__item <?= !empty($errors['password']) ? 'form__item--invalid' : ''; ?>">
    <label for="password">Пароль <sup>*</sup></label>
    <input id="password" type="password" name="password" placeholder="Введите пароль">
    <?php if (!empty($errors['password'])): ?>
    <span class="form__error"><?= $errors['password']; ?></span>
    <?php endif; ?>
  </div>
  <div class="form__item <?= !empty($errors['name']) ? 'form__item--invalid' : ''; ?>">
    <label for="name">Имя <sup>*</sup></label>
    <input id="name" type="text" name="name" placeholder="Введите имя" value="<?= getPostVal('name'); ?>">
    <?php if (!empty($errors['name'])): ?>
    <span class="form__error"><?= $errors['name']; ?></span>
    <?php endif; ?>
  </div>
  <div class="form__item <?= !empty($errors['message']) ? 'form__item--invalid' : ''; ?>">
    <label for="message">Контактные данные <sup>*</sup></label>
    <textarea id="message" name="message" placeholder="Напишите как с вами связаться"><?= getPostVal('message'); ?></textarea>
    <?php if (!empty($errors['message'])): ?>
    <span class="form__error"><?= $errors['message']; ?></span>
    <?php endif; ?>
  </div>
  <?php if(isset($errors)): ?>
  <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
  <?php endif; ?>
  <button type="submit" class="button">Зарегистрироваться</button>
  <a class="text-link" href="#">Уже есть аккаунт</a>
</form>
