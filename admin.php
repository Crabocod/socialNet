<?php 
require_once "conn.php";
if (isset($_POST["delete"])) {
	$sql = "DELETE FROM users WHERE id = {$_POST["delete"]}";
	$result = $conn->query($sql);
    if ($result) {
        header("Location:admin.php");
    } else {
        echo mysqli_error($conn);
    }
}
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>admin</title>
</head>
<body>
<?php
echo "<table border = '1' cellpadding='5'><tr><th>id</th><th>login</th></tr></table>";  
while ($row = $result->fetch_assoc()) {
	echo "<table border = '1' cellpadding='5';>
		  <tr><td>".$row['id']."</td><td>".$row['login']."</td><td><form method='POST' action=''><input type='hidden' name='delete' value=".$row['id']."><input type='submit' value='Delete'></form></td><td><button onclick='update(".$row['id'].")'>Update</button></td></tr>
		  </table>";
}

?>
<form class="c" action="create.php" method="POST">
	<input type="submit" value="Create">
</form>
<button class="b" onclick="back()">Back</button>

	<style>
	.c{
		margin-top:20px;
	}
	.b{
		margin-top:20px;
	}
	</style>
	<script>
		function back(){
			document.location.href = "index.php";
		}
		function update(id) {
			var newLogin = prompt("Введите новый логин");
			var request = new XMLHttpRequest();

			request.open('POST', 'ajax.php' );
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			request.send("id="+id+"&login="+newLogin);
			location.reload();
		}
	</script>
</body>
</html>