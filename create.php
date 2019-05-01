<?php  
require_once "conn.php";
if (isset($_POST['login']) && isset($_POST['password'])) {
	$login = $_POST["login"];
	$pass = md5($_POST["password"]);
	$sql = "INSERT INTO users(login, pass)
				VALUES ('$login', '$pass')";
	if ($conn->query($sql) === TRUE) {
			$_SESSION["login"] = $login;
			header("Location:admin.php");
		}
		else{
			?><p style="color: red">Error</p><?php
		}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Create</title>
</head>
<body>
	<form action="" method="POST">
		<label for="login">Логин:</label>
      <input type="text" name="login" id="login">
      <label for="password">Пароль:</label>
      <input type="password" name="password" id="password">
      <input type="submit" value="Send">
	</form>
</body>
</html>