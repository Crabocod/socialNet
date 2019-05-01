<?php 
require_once "conn.php";
if (isset($_POST["post_id"]) && isset($_POST["login"])) {
	$post_id = $_POST["post_id"];
	$login = $_POST["login"];

	$sql = "SELECT * FROM likes WHERE user_login = '$login' AND post_id = '$post_id'";
	$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	$count = mysqli_num_rows($result);
	if ($count) {
		$sql = "DELETE FROM likes WHERE user_login = '$login' AND post_id = '$post_id'";
		if ($conn->query($sql) === TRUE) {
			$sql = "SELECT * FROM likes WHERE post_id = '$post_id'";
			$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
			$count = mysqli_num_rows($result);
			echo $count;
		}
	}
	else{
		$sql = "INSERT INTO likes(post_id, user_login)
				VALUES('$post_id', '$login')";
		if ($conn->query($sql) === TRUE) {
			$sql = "SELECT * FROM likes WHERE post_id = '$post_id'";
			$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
			$count = mysqli_num_rows($result);
			echo $count;
		}
	}
}
else if(isset($_POST["id"]) && isset($_POST["login"])){
	$id = $_POST["id"];
	$login = $_POST["login"];
	$sql = "UPDATE users
            SET login = '$login'
            WHERE id = '$id'";
    mysqli_query($conn, $sql);
}
?>