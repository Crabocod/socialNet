<?php 
ob_start();
session_start();
require_once "conn.php";
unset($_SESSION["login"]);
if (isset($_POST['login']) && isset($_POST['password'])) {
	if ($_POST['login'] == "admin" && $_POST['password'] == "adminadmin") {
		header("Location: admin.php");
	}
	$login = $_POST["login"];
	$pass = md5($_POST["password"]);
	$sql = "SELECT * FROM users WHERE login = '$login' AND pass = '$pass'";
	$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	$count = mysqli_num_rows($result);

	if ($count == 1) {
		$_SESSION["login"] = $login;
		$_SESSION["pass"] = $_POST["password"];
		$_SESSION["create"] = time();
		header("Location: index.php");
	}
	else{
		?><p style="color: red; font-size: 20px;">Введите корректные данные</p><?php
	}
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>SignUp</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="icon" href="http://vladmaxi.net/favicon.ico" type="image/x-icon">
	<link rel="shortcut icon" href="http://vladmaxi.net/favicon.ico" type="image/x-icon">
	<!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
<p class="SignUp">Вход</p>
  <form method="post" action="" class="login">
    <p>
      <label for="login">Логин:</label>
      <input type="text" name="login" id="login" placeholder="name@example.com">
    </p>

    <p>
      <label for="password">Пароль:</label>
      <input type="password" name="password" id="password" placeholder="***********">
    </p>
	<a href="signUp.php">Регистрация</a>
    <p class="login-submit">
      <button name="send" type="submit" class="login-button">Войти</button>
    </p>
  </form>
</body>
</html>
