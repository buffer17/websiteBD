<?php include 'connect.php'; ?>
<!DOCTYPE html>
<gtml lang="ru">

<head>
	<meta charset="UTF-8">
	<title>Интернет-Магазин автозапчастей - авторизация</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<button class="button" onclick="window.location.href='index.php'">Главная страница</button>
	 <button class="button" onclick="window.location.href='buy.php'">Купить детали</button>
	 <button class="button" onclick="window.location.href='list_det.php'">Список деталей</button> 
	 <button class="button" onclick="window.location.href='contactus.php'">Контакты</button>
	
	 <?php
	 session_start();
	 if (isset($_SESSION['code']) && !empty($_SESSION['code'])) {
		echo "<button class=\"button\" onclick=\"window.location.href='LK.php'\">ЛК</button>";
		echo '<form method="post"><button class="button" type="submit" name="logout">Выйти</button></form>';
	 } else {
		echo"<button class=\"button\" onclick=\"window.location.href='logIn.php'\">Авторизация</button>";
		echo"<button class=\"button\" onclick=\"window.location.href='reg.php'\">Регистрация</button>";
	 }

	 if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST['logout'])) {
			unset($_SESSION['code']);
			session_write_close();
			header("Location: logIN.php");
			exit();
		}
	 }
	 ?>

	<h2>Авторизация</h2>
	<div id="авторизация">
	<form method="post">
	<?php
	echo "<table>";
	echo "<tr><th>Логин</th><th>Пароль</th></tr";
	echo "<tr><td><input type='text' name='Логин_'></td>
		<td><input type='password' name='Пароль_'></td></tr>";
	echo "</table>";
	echo "<input type='submit' name='submit' value='Войти' class='button'>";
	?>
	</form>

	<?php
	session_start();
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST['submit'])) {
			$login = $_POST['Логин_'];
			$password = $_POST['Пароль_'];
			$sql_ = "SELECT * FROM покупатели WHERE Логин = '$login' AND Пароль = '$password'";
			$resu = $conn->query($sql_);
			if ($resu->num_rows > 0) {
				$_SESSION['code'] = $resu->fetch_assoc()['Номер_покупателя'];
				header("Location: LK.php");
				exit();
			} else { echo "Пользователь не нейден"; }
			$conn->close();
		}
	}
	?>
</body>
</html>
