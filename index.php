<?php 
ob_start();
session_start();
require_once "conn.php";
if (isset($_SESSION["create"])) {
	if ($_SESSION["login"] == "admin" && $_SESSION["pass"] == "adminadmin") {
		echo "Привет админ";
	}
	$now = time();
	$limit = 10000;
	if ($now > $_SESSION["create"] + $limit) {
		 session_destroy();
		 header("Location: signIn.php");
	}
	else{
		$_SESSION["create"] = time();
	}
}
if ($_FILES['userAttach']['error'] == 0  && isset($_POST["text"])) {
	$name = $_SESSION["login"];
	$postText = $_POST["text"];
	$path = "userAttach/";
	$newName = time().".".$_FILES["userAttach"]["name"];
	$fullPath = $path.$newName;
	$fullPath = str_replace(' ', '', $fullPath);
	if ($_FILES["userAttach"]["error"] == 0) {
		if (move_uploaded_file($_FILES['userAttach']['tmp_name'], $fullPath)) {
			$sql = "INSERT INTO post(name, post, photoPath)
					VALUES('$name', '$postText', '$fullPath')";
			if ($conn->query($sql) === TRUE) {
				header("Location: index.php");
			}
			else{
				echo "error";
			}
		}
	}
	else{
		echo "Ошибка отправки фото на сервер: ".$_FILES['userAttach']['error'];
	}
}
elseif (isset($_POST["text"])) {
 	$name = $_SESSION["login"];
	$postText = $_POST["text"];
	$sql = "INSERT INTO post(name, post)
			VALUES('$name', '$postText')";
	if ($conn->query($sql) === TRUE) {
		header("Location: index.php");
	}
	else{
		echo mysqli_error($conn);
	}
}
if (isset($_POST["delete"])) {
	$sql = "DELETE FROM post WHERE id = {$_POST["delete"]}";
	$result = $conn->query($sql);
    if ($result) {
        header("Location:index.php");
    } else {
        echo mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>SymbolBlog</title>
	<link rel="stylesheet" href="css.css">
	<link href="https://fonts.googleapis.com/css?family=Lato:400,700,700i" rel="stylesheet">
</head>
<body>
	<div class="flex">
		<div class="leftBar">
			<div class="logo flex">
				<img src="img/Shape 8.png" alt="">
			</div>
			<div class="blogName flex">SymbolBlog</div>
			<div class="nav">
				<div class="el flex">
					<div class="img"></div>
					<p class="strName">Все посты</p>
				</div>
				<div class="el flex">
					<div class="img1"></div>
					<p class="strName">Галлерея</p>
				</div>
			</div>
			<div class="about">
				<h1 class="aboutTitle">About us</h1>
				<p class="aboutText">Проста сделал блог крч, практикуюсь тип все дела, тут нужен рыбный текст вот я и пишу чета. Начал вот новое предложение,продолжаю писатб,держу в курсе,думаю хватит...</p>
			</div>
		</div>
		<div class="content">
			<div class="blueLine"></div>
			<div class="title flex">
				<div class="strTitle">Главная</div>
				<div class="sign flex">
			<?
				if (isset($_SESSION["login"])) {
					?> <p class="userLogin"><?echo $_SESSION["login"]?></p></div>
					<a class="out" href="signIn.php">Выйти</a><?
				}
				else{
					?>
					<div class="signIn"><a href="signIn.php">Войти</a></div>/
					<div class="signUp"><a href="signUp.php">Регистрация</a></div>
				</div>
			<? }
				?>
			</div>
			<?php if (isset($_SESSION["login"])) { ?>
				<button class="nPost" onclick="newPost()">Новый пост</button>
			<?} ?>
			<form enctype="multipart/form-data" class="newPost" action="" method="POST">
				
				<textarea name="text" cols="30" rows="10" placeholder="Поделитесь чем-нибудь..."></textarea><br>
				<label for="attach" onclick="fileVis()" class="attach">Прикрепить</label>
				<input type="file" name="userAttach" id="attach" class="addFile">
				<input class="posted" type="submit" value="Опубликовать">
			</form>
			<?php  
				$content = "SELECT * FROM post";
				$result = $conn->query($content);
				while ($row = $result->fetch_assoc()) {?>
					<div class='post'><h2 class='namePost'><?echo $row["name"]?></h2><hr><p class='textPost'><?echo $row["post"]?></p><?if(!empty( $row["photoPath"] ) ) { ?><img class="attachFile" style='width:200px; border:2px solid black;' src=<? echo $row["photoPath"]?> >
					<? } ?>
					<br><div class="flex"><div class="numLike" id=<?echo $row["id"]?>> <? 
					$sql = "SELECT * FROM likes WHERE post_id = {$row["id"]}";
				$numLike = mysqli_query($conn, $sql) or die(mysqli_error($conn));
				$count = mysqli_num_rows($numLike); echo $count; ?></div><div class=<?
				$sql = "SELECT * FROM likes WHERE post_id = {$row["id"]} AND user_login = '{$_SESSION["login"]}'";
				$res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
				$count = mysqli_num_rows($res); 
				 if($count == 1){
				 	echo "like2";
				 } 
				 else{
				 	echo "like1";
				 }	
				 ?> id="<?echo $row['id']."like"?>" onclick="<? if (isset($_SESSION["login"])) {?> 
				 	like(<? echo $row["id"].",'".$_SESSION['login']."'"?>, this.id)
				 	<?}?>">
				  	</div></div></div><? if ($_SESSION["login"] == $row["name"]){ ?><form action='' method='post'><input type='hidden' name='delete' value=<? echo $row["id"]?> ><input type='submit' class="deletePost" value='Удалить'></form>
					<? } ?>
				<? } ?>
		</div>
	</div>
	<script src="script.js"></script>
</body>
</html>