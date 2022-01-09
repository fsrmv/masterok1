<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?=PATH?>css/bootstrap.min.css">
  <link rel="stylesheet" href="<?=PATH?>css/style.css">
  <title>Главная страница</title>
</head>
<body>

  <!-- Модальное окно авторизации -->
  <div class="modal fade" id="auth" tabindex="-1"  style="z-index: 999999" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Авторизация</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post" onsubmit="checkUser(this, event)" >
        <div class="modal-body">
          <input type="text" name="loginAuth" placeholder="Логин" pattern="^[A-Za-z.]+$" class="form-control" required><br>
          <input type="password" name="passAuth" placeholder="Пароль" class="form-control" required>
          <small id="errorAuth" style="color: red; font-weight: 500; display: none;">Неправильная пара логин-пароль!</small><br>
        </div>
        <div class="modal-footer">
          <button type="submit" name="auth" class="btn btn-secondary">Войти</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Модальное окно регистрации -->
  <div class="modal fade" id="reg" tabindex="-1"  style="z-index: 999999" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Регистрация</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post">
        <div class="modal-body">
          <input type="text" name="fio" placeholder="ФИО" pattern="^[А-Яа-яЁё\s]+$" class="form-control" required><br>
          <input type="text" name="login" placeholder="Логин" pattern="^[A-Za-z.]+$" class="form-control" required onchange="checkLogin(this)">
          <small id="errorLogin" style="color: red; font-weight: 500; display: none">Логин уже занят!</small><br>
          <input type="email" name="email" placeholder="Email" class="form-control" required><br>
          <input type="password" name="pass1" placeholder="Пароль" class="form-control" required><br>
          <input type="password" name="pass2" placeholder="Повторите пароль" class="form-control" required required onchange="checkPass(this)">
          <small id="errorPass" style="color: red; font-weight: 500; display: none">Пароли не совпадают!</small><br>
          <input type="checkbox" name="sogl" required id="sogl"><label for="sogl"> Согласие на обработку персональных данных</label>
        </div>
        <div class="modal-footer">
          <button type="submit" name="reg" class="btn btn-secondary">Зарегестрироватся</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Заголовок сайта и его обложка -->
  <section id="header">
    <div class="m_image">
    <div class="container" >
      <header class="d-flex flex-wrap align-items-start justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <a href="#"><img src="../../views/img/logo_OK.png" id="logo"></a>
        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
          <li><a href="#" class="nav-link px-2 link-light">Главная</a></li>
          <li><a href="#" class="nav-link px-2 link-light">Услуги</a></li>
          <li><a href="#" class="nav-link px-2 link-light">Проекты</a></li>
          <li><a href="#" class="nav-link px-2 link-light">Контакты</a></li>
        </ul>
        <div class="col-md-3 text-end">
          <?php if(isset($_SESSION['login']) && !empty($_SESSION['login'])): ?>
              <?php if($_SESSION['is_admin'] == 1): ?>
              <a href="/master" class="btn btn-outline-light">Панель управления</a>
              <a href="/exit" class="btn btn-light">Выход</a>
              <?php else: ?>
              <a href="/profile" class="btn btn-outline-light">Личный кабинет</a>
              <a href="/exit" class="btn btn-light">Выход</a>
              <?php endif; ?>
              <?php else: ?>
              <a href="#" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#auth">Войти</a>
              <a href="#" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#reg">Регистрация</a>
              <?php endif; ?>
        </div>
      </header>

      <!-- Обложка сайта -->
      <div class="container d-flex justify-content-center" id="cen">
        <div class="row" align="center">
          <div class="col-12">
            <br><br><br><br><br><br>
            <h1>МастерОК - ваш лучший друг!</h1>
            <h3>Надежные дома для спокойной жизни.</h3>
            <a href="#orders" class="btn btn-light">К заявкам</a>
            <br><br><br><br><br>
          </div>
        </div>
      </div><br>
    </div>
    </div>
  </section>

  <!-- Карточки заказов -->
  <section id="orders" name="orders">
    <div class="container">
      <div class="row">
        <div class="col-10"><br>
          <h4>Выполненные заявки</h4>
          </div>
          <div class="col-2"><br>
            <h5><span class="badge bg-dark"><span id="countOrders"><?=$count[0]['count'] ?></span> выполненных заявок</span></h5>
          </div>
        </div><br>
        <div class="row">
          <?php foreach ($orders as $o):?>
          <div class="col-lg-3 col-sm-6 my-sm-3">
            <div class="card">
              <div class="img">
                <div class="cardText" style="top: 0; left: 0;">
                  <?=$o['o_timestamp'] ?>
                </div>
                <div class="cardText" style="right: 0; bottom: 0;">
                  <?=$o['o_status'] ?>
                </div>
                <div class="img1" style="background-image: url(<?=PATH?>img/<?=$o['o_img1']?>)"></div>
                <div class="img2" style="background-image: url(<?=PATH?>img/<?=$o['o_img2']?>)"></div>
              </div>
              <div class="card-body">
                <h5 class="card-title"><?=$o['c_name'] ?></h5>
                <p class="card-text"><?=$o['o_address'] ?></p>
                <hr>
                <p class="card-text"><?=$o['o_desc'] ?></p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
        </div>
      </div>
      <br>
    </section>

    <!-- Футер сайта -->
    <section id="footer">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <p>2021 &copy;МастерОК Все права защищены!</p>
          </div>
        </div>
      </div>
    </footer>

    <script src="<?=PATH?>js/bootstrap.min.js"></script>
    <script src="<?=PATH?>js/main.js"></script>
    <script src="<?=PATH?>js/jquery-3.4.1.min.js"></script>

</body>
</html>