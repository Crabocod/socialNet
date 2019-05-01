<?php 
ob_start();
session_start();
require_once "conn.php";
if (isset($_POST["send"])) {

	if (empty($_POST["login"]) || empty($_POST["password"])) {
		?><p style="color: red; font-size:20px;">Введите данные!</p><?php
	}
	else{
		$login = $_POST["login"];
		$pass = md5($_POST["password"]);
		$sql = "INSERT INTO users(login, pass)
				VALUES ('$login', '$pass')";
		if ($conn->query($sql) === TRUE) {
			$_SESSION["login"] = $login;
			header("Location:index.php");
		}
		else{
			?><p style="color: red">Error</p><?php
		}
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
<p class="SignUp">Регистрация</p>
  <form method="post" action="" class="login">
    <p>
      <label for="login">Логин:</label>
      <input type="text" name="login" id="login" placeholder="name@example.com">
    </p>

    <p>
      <label for="password">Пароль:</label>
      <input type="password" name="password" id="password" placeholder="***********">
    </p>
<a href="signIn.php">Уже есть аккаунт?</a>
    <p class="login-submit">
      <button name="send" type="submit" class="login-button">Войти</button>
    </p>
  </form>
</body>
</html>
