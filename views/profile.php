<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?=PATH?>css/bootstrap.min.css">
  <link rel="stylesheet" href="<?=PATH?>css/style.css">
  <title>Личный кабинет</title>
</head>
<body>

  <!-- Заголовок сайта и его обложка -->
  <section id="header">
    <div class="p_image">
      <div class="container">
        <header class="d-flex flex-wrap align-items-start justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
          <a href="/"><img src="../../views/img/logo_OK.png" id="logo"></a>
          <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="#" class="nav-link px-2 link-light">Главная</a></li>
            <li><a href="#" class="nav-link px-2 link-light">Услуги</a></li>
            <li><a href="#" class="nav-link px-2 link-light">Проекты</a></li>
            <li><a href="#" class="nav-link px-2 link-light">Контакты</a></li>
          </ul>
          <div class="col-md-3 text-end">
            <?php if(isset($_SESSION['login']) && !empty($_SESSION['login'])) : ?>
            <a href="/?view=profile" class="btn btn-outline-light">Личный кабинет</a>
            <a href="/?exit" class="btn btn-light">Выйти</a>
            <?php else: ?>
              <a href="#" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#auth">Войти</a>
              <a href="#" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#reg">Зарегестрироваться</a>
            <?php endif; ?>
          </div>
        </header>

        <!-- Обложка сайта -->
        <div class="container d-flex align-items-center justify-content-center" id="cen">
          <div class="row" align="center">
            <div class="col-12">
              <h1>Добро пожаловать, <?=$_SESSION['fio']?>!</h1>
              <h3>
                <?php 
                if ($_SESSION['login'] != 'admin') {
                  echo 'Пользователь';
                } else {
                  echo 'Администратор';
                }
                ?>
              </h3>
              <a href="#my_orders" class="btn btn-light">К заявкам</a>
              <br><br><br><br><br>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="my_orders">
    <div class="container">
      <div class="row">
        <div class="col-10">
          <h2>Мои заявки</h2>
        </div>
        <div class="col-2">
          <a href="#" class="btn btn-dark" onclick="openForm()">Создать заявку</a>
        </div>
        <div id="ordersForm">
          <div class="row">
            <div class="col-12">
              <form method="post" enctype="multipart/form-data"><br>
                <textarea name="address" cols="30" rows="2" placeholder="Адрес помещения" required class="form-control"></textarea><br>
                <textarea name="desc" cols="30" rows="2" placeholder="Описание" required class="form-control"></textarea><br>
                <select name="cats" class="form-select">
                  <option disabled selected>Выберите категорию</option>
                  <?php foreach ($cats as $c) : ?>
                    <option value="<?=$c['c_id']?>"><?=$c['c_name']?></option>
                  <?php endforeach; ?>
                </select><br>
                <input type="number" name="price" placeholder="Максимальная цена" required class="form-control"><br>
                <input type="file" name="photo" accept=".png, .jpg, .jpeg, .bmp" required class="form-control"><br>
                <input type="submit" id="add_order" name="add_order" class="btn btn-outline-dark" value="Добавить">
              </form><br>
            </div>
          </div>
        </div><br><br><br>

        <?php if (!empty($myOrders)): ?>
          <form method="post">
            <div class="row">
              <div class="col-10">
                <select name="status" class="form-select">
                  <option disabled selected>Выберите статус заявки</option>
                  <option value="Новая">Новая</option>
                  <option value="Ремонтируется">Ремонтируется</option>
                  <option value="Отремонтировано">Отремонтировано</option>
                </select>
              </div>
              <div class="col-2">
                <button type="submit" name="sort" class="btn btn-outline-dark w-70">Сортировать</button>
              </div>
            </div>
          </form><br><br>
          <div class="row">
            <?php foreach($myOrders as $o): ?>
              <div class="col-4">
                <div class="card">
                  <div class="img" style="background: url(<?=PATH?>img/<?=$o['o_img1']?>) center center no-repeat; height: 250px">
                    <div class="timestamp"><?=$o['o_timestamp']?></div>
                  </div>
                  <div class="card-body">
                    <h5>Категория: <?=$o['c_name']?></h5><hr>
                    <p><b>Адрес: </b><?=$o['o_address']?></p>
                    <p><b>Описание: </b><?=$o['o_desc']?></p>
                    <?php if($o['o_status'] == 'Ремонтируется' || $o['o_status'] == 'Отремонтировано'): ?>
                      <p><b>Согласованная цена: </b><?=$o['o_price1']?> руб.</p>
                      <?php else: ?>
                        <p><b>Предложенная цена: </b><?=$o['o_price2']?> руб.</p>
                      <?php endif; ?>
                      <p><b>Статус: </b><?=status($o['o_status'])?></p>
                      <a href="/?view=profile&del=<?=$o['o_id']?>" class="btn btn-outline-dark" onclick="return confirm('Вы действительно хотите удалить заявку?');">Удалить</a>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
              <?php else: ?>
                <h2 align="center">У вас нет созданных заявок</h2>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </section>

      <!-- Футер сайта -->
      <footer>
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