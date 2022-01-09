<?php

	// Функция удаления пробелов, преобразования html и PHP тэгов
function clear($q) {
	return trim(strip_tags(htmlspecialchars($q)));
}

	// ?????
function set($q) {
	global $conn;
	$res = $conn->query("$q");
	$data = [];
	while ($row = $res->fetch_assoc()) {
		$data[] = $row;
	}
	return $data;
}

	// Проверка уникальности логина из БД
function checkLogin() {
	$login = clear($_POST['checkLogin']);

	$check = set("SELECT * FROM users WHERE u_login = '{$login}'");

	if (empty($check)) {
		return 'yes';
	} else {
		return 'no';
	}
}

	// Функция очистки формы на сайте и авторизации
function checkUser() {
	$login = clear($_POST['loginAuth']);
	$pass = clear($_POST['passAuth']);
	$pass = md5($pass);

	$user = set("SELECT * FROM users WHERE u_login = '{$login}' AND u_pass = '{$pass}'");

	if (!empty($user)) {
		$_SESSION['id'] = $user[0]['u_id'];
		$_SESSION['fio'] = $user[0]['u_fio'];
		$_SESSION['login'] = $user[0]['u_login'];
		$_SESSION['email'] = $user[0]['u_email'];
		$_SESSION['is_admin'] = $user[0]['u_is_admin'];
		header("Location: /");
	} else {
		return 'no';
	}
}

    // Функция очистки формы на сайте и отправка формы в БД
function reg() {
	$fio = clear($_POST['fio']);
	$login = clear($_POST['login']);
	$email = clear($_POST['email']);
	$pass = clear($_POST['pass1']);
	$pass = md5($pass);

	global $conn;
	$conn->query("INSERT INTO users(u_fio, u_login, u_email, u_pass) VALUES ('$fio', '$login', '$email', '$pass')");
	if ($conn->affected_rows > 0) {
		header("Location: /");
	} else {
		echo $conn->error;
	}
}

	// Функция выхода из личного профиля
function logOut() {
	unset($_SESSION['fio']);
	unset($_SESSION['login']);
	unset($_SESSION['email']);
	unset($_SESSION['is_admin']);
	header("Location: /");
}

	// Счетчик
function checkOrders() {
	$orders = set("SELECT COUNT(o_id) AS 'count' FROM orders WHERE o_status = 'Отремонтировано'");
	return $orders[0]['count'];
}

function addOrder() {
	if ($_FILES['photo']['size'] > 2097152) {
		return 'Размер файла превышает допустимый';
	} else {
		$uploadDir = 'C:/openserver/domains/masterok/views/img/';
		$uploadFile = $uploadDir.basename($_FILES['photo']['name']);

		if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
			$address = clear($_POST['address']);
			$desc = clear($_POST['desc']);
			$cat = clear($_POST['cats']);
			$price = clear($_POST['price']);
			$img = basename($_FILES['photo']['name']);

			global $conn;

			$conn->query("INSERT INTO orders(o_address, o_desc, o_cat, o_price1, o_img1, o_user) VALUES ('$address', '$desc', '$cat', '$price', '$img', '{$_SESSION['id']}')");
			if ($conn->affected_rows > 0) {
				header("Location: /?view=profile");
			} else {
				return $conn->error;
			}
		} else {
			return 'Ошибка при загрузке файла!';
		}
	}
}

function status($status) {
	switch($status){
		case 'Новая':
		return '<span style="color: green;"><b>'.$status.'</b></span>';

		case 'Ремонтируется':
		return '<span style="color: orange;"><b>'.$status.'</b></span>';

		case 'Отремонтировано':
		return '<span style="color: gray;"><b>'.$status.'</b></span>';
	}
}

function deleteOrder() {
	$id = clear($_GET['del']);

	global $conn;
	$conn->query("DELETE FROM orders WHERE o_id = '{$id}'");
	if ($conn->affected_rows > 0) {
		header("Location: /?view=profile");
	} else {
		echo $conn->error;
	}
}

function delCat() {
	$id = clear($_GET['delCat']);

	global $conn;
	$conn->query("DELETE FROM cats WHERE c_id = '{$id}'");
	if ($conn->affected_rows > 0) {
		header("Location: /master");
	} else {
		echo $conn->error;
	}
}

function addCat() {
	$name = clear($_POST['nameCat']);

	global $conn;
	$conn->query("INSERT INTO cats(c_name) VALUES('$name')");
	if ($conn->affected_rows > 0) {
		header("Location: /master");
	} else {
		echo $conn->error;
	}
}

function changeStatus() {
	$id = clear($_POST['idOrder']);
	if (empty($_FILES['photo2'])) {
		$price = clear($_POST['price']);
		global $conn;
		$conn->query("UPDATE orders SET o_status = 'Ремонтируется', o_price2 = '{$price}' WHERE o_id = '{$id}'");
		if ($conn->affected_rows > 0) {
			header("Location: /master");
		} else {
			echo $conn->error;
		}
	} else {
		$uploadDir = 'C:/OpenServer/domains/de/views/img/';
		$uploadFile = $uploadDir.basename($_FILES['photo2']['name']);

		if (move_uploaded_file($_FILES['photo2']['tmp_name'], $uploadFile)) {
			global $conn;
			$conn->query("UPDATE orders SET o_status = 'Отремонтировано', o_img2 = '{$_FILES['photo2']['name']}' WHERE o_id = '{$id}'");
			if ($conn->affected_rows>0) {
				header("Location: /master");
			} else {
				echo $conn->error;
			}
		}
	}
}

?>