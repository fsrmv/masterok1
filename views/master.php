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
						</div>
					</div>
				</div>
			</div>
		</div>
	</section><br><br>

	<section id="myOrders">
		<div class="container">
			<div class="row">
				<div class="col-10">
					<h2>Управление категориями</h2>
				</div>
				<div class="col-2">
					<a href="#" class="btn btn-dark w-100" onclick="event.preventDefault();$('div#addCat').slideToggle(300);">Добавить категорию</a>
				</div>
			</div><br>
			<div id="addCat" style="display: none;">
				<div class="row">
					<div class="col-12">
						<form method="post">
							<input type="text" name="nameCat" placeholder="Название категории" required class="form-control"><br>
							<button type="submit" name="addCat" class="btn btn-outline-dark">Добавить категорию</button>
						</form>
					</div>
				</div><br><br>
			</div>
			<div class="row">
				<div class="col-12">
					<?php foreach($cats as $c): ?>
						<div class="row d-flex align-items-center">
							<div class="col-10"><?=$c['c_name']?></div>
							<div class="col-2">
								<a href="/?view=master&delCat=<?=$c['c_id']?>" onclick="return confirm('Вы действительно хотите удалить категорию?')" class="btn btn-outline-dark w-100">Удалить</a>
							</div>
						</div><br>
					<?php endforeach; ?>
				</div>
			</div><br><br>

			<div class="row">
				<div class="col-12">
					<h2>Все заявки</h2>
				</div>
			</div><br>

			<form method="post">
				<div class="row">
					<div class="col-10">
						<select name="status" class="form-select">
							<option disabled selected>Укажите статус</option>
							<option value="Новая">Новая</option>
							<option value="Ремонтируется">Ремонтируется</option>
							<option value="Отремонтировано">Отремонтировано</option>
						</select>
					</div>
					<div class="col-2">
						<button type="submit" class="btn btn-dark w-100" name="sort">Сортировать</button>
					</div>
				</div>
			</form><br><br>
			<?php if(!empty($myOrders)): ?>

				<div class="row">
					<?php foreach($myOrders as $o): ?>
						<div class="col-12 mb-3">
							<div class="card">
								<div class="row">
									<div class="col-3">
										<div class="img_master" style="background: url(<?=PATH?>img/<?=$o['o_img1']?>) center center no-repeat; height: 250px;"><div class="timestamp_master"><?=$o['o_timestamp']?></div></div>
									</div>
									<div class="col-9">
										<div class="card-body">
											<h5 class="card-title"><?=$o['c_name']?></h5>
											<p><b><?=$o['o_address']?></b></p>
											<p class="card-text"><?=$o['o_desc']?></p>
											<?php if($o['o_status'] == 'Ремонтируется' || $o['o_status'] == 'Отремонтировано'): ?>
												<p><b>Согласованная цена: </b><?=$o['o_price2']?> руб.</p>
												<?php else: ?>
													<p><b>Предложенная цена: </b><?=$o['o_price1']?> руб.</p>
												<?php endif; ?>

												<?php if ($o['o_status'] == 'Новая'): ?>
													<select class="form-select w-auto" onchange="changeStatus(this, <?=$o['o_id']?>)">
														<option disabled selected>Новая</option>
														<option value="Ремонтируется">Ремонтируется</option>
														<option value="Отремонтировано">Отремонтировано</option>
													</select><br>
													<div id="formPrice<?=$o['o_id']?>" style="display: none;">
														<form method="post">
															<div class="row">
																<div class="col-9">
																	<input type="text" name="price" placeholder="Согласованная цена" class="form-control" required>
																	<input type="hidden" name="idOrder" value="<?=$o['o_id']?>">
																</div>
																<div class="col-3">
																	<button type="submit" name="changeStatus" class="btn btn-danger w-100">Сменить статус</button>
																</div>
															</div>
														</form>
													</div>
													<div id="formPhoto<?=$o['o_id']?>" style="display: none;">
														<form method="post" enctype="multipart/form-data">
															<div class="row">
																<div class="col-9">
																	<input type="file" name="photo2" class="form-control" required>
																	<input type="hidden" name="idOrder" value="<?=$o['o_id']?>">
																</div>
																<div class="col-3">
																	<button type="submit" name="changeStatus" class="btn btn-danger w-100">Сменить статус</button>
																</div>
															</div>
														</form>
													</div>
													<?php else: ?>
														<p><b>Статус: </b><?=status($o['o_status'])?></p>
													<?php endif; ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
							<?php else: ?>
								<div align="center"><h2>Нет заявки с таким статусом</h2></div>
							</div>
						<?php endif; ?>
					</div>
				</section><br>

				<footer>
					<div class="container">
						<div class="row">
							<div class="col-12">
								2021 &copy;МастерОК. Все права защищены! 
							</div>
						</div>
					</div>
				</footer>

				<script src="<?=PATH?>js/jquery-3.4.1.min.js"></script>
				<script src="<?=PATH?>js/main.js"></script>
				<script src="<?=PATH?>js/bootstrap.min.js"></script>

			</body>
			</html>