<?php 

	session_start();

	require 'model/model.php';

	// $view = empty($_GET['view']) ? 'main' : $_GET['view'];

	if (empty($_GET['view'])) {
	    $view = 'main';
    } else {
	    $view = $_GET['view'];
    }

	if (isset($_GET['exit'])) {
		logOut();
	}

	switch ($view) {
		case 'main':
		if (isset($_POST['checkLogin'])) {
			$res = checkLogin();
			echo $res;
			die();
		}

		if (isset($_POST['loginAuth'])) {
			$res = checkUser();
			echo $res;
			die();
		}

		if (isset($_POST['reg'])) { reg();}

		$orders = set("SELECT * FROM orders INNER JOIN cats ON cats.c_id = orders.o_cat WHERE o_status = 'Отремонтировано' ORDER BY o_timestamp DESC LIMIT 4");
		$count = set("SELECT COUNT(o_id) AS 'count' FROM orders WHERE o_status = 'Отремонтировано'");

		if (isset($_POST['info'])) {
			$res = checkOrders();
			echo $res;
			die();
		}

		break;

		case 'profile':

		if (!isset($_SESSION['fio'])) {
		    header("Location: /");
	    }

		if (isset($_POST['add_order'])) {
			$addOrder = addOrder();
			print_r($addOrder);
		}

		$cats = set("SELECT * FROM cats");

		$myOrders = set("SELECT * FROM orders INNER JOIN cats ON cats.c_id = orders.o_cat WHERE o_user = '{$_SESSION['id']}' ORDER BY o_timestamp ASC");

		if (isset($_GET['del'])) {
			deleteOrder();
		}

		if (isset($_POST['sort'])) {
		    $myOrders = set("SELECT * FROM orders INNER JOIN cats ON cats.c_id = orders.o_cat WHERE o_user = '{$_SESSION['id']}' AND o_status = '{$_POST['status']}' ORDER BY o_timestamp ASC");
      	}

		break;

		case 'master':
	
	    if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
		    header("Location: /");
	    }

	    $myOrders = set("SELECT * FROM orders INNER JOIN cats ON cats.c_id = orders.o_cat ORDER BY o_timestamp ASC");

	    if (isset($_POST['sort'])) {
		    $myOrders = set("SELECT * FROM orders INNER JOIN cats ON cats.c_id = orders.o_cat WHERE o_status = '{$_POST['status']}' ORDER BY o_timestamp ASC");
	    }

	    $cats = set("SELECT * FROM cats");

	    if (isset($_GET['delCat'])) {
		    delCat();
	    }

	    if (isset($_POST['addCat'])) {
		    addCat();
	    }

	    if (isset($_POST['changeStatus'])) {
		    changeStatus();
	    }

	    break;
		
		default:
		header("Location: /");
		break;
	}


	require 'views/index.php';
 ?>