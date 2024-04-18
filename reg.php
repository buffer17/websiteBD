<DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<title>Интернет-Магазин автозапчастей - Регистрация</title>
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
		echo "<button class=\"button\" onclick=\"window.location.href='лк.php'\">ЛК</button>";
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

	 <form method="post">
	 <table>
	 <th><label name="text">Название</label></th>
	 <th><label name"text2">Данные</label></th>
	 <tr>
		<td><label for="fullname">Имя клиента:</label></td>
		<td><input type="text" id="fullname" name="fullname" required></td>
	 </tr>
	 <tr>
		<td><abel for="login">Логин:</label></td>
		<td><input type="text" id="login" name="login" required></td>
	 </tr>
	 <tr>
		<td><label for="password">Пароль:</label></td>
		<td><input type="password" id="password" name="password" required></td>
	 </tr>
	 </table>

	 <br><button type="sumbit" class="button">Зарегистрироваться</button>
	 </form>

	 <?php
	 include 'connect.php';
	 if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$count_query = "SELECT COUNT(*) as total FROM покупатели";
		$result = $conn->query($count_query);
		$row = $result->fetch_assoc();
		$total_rows = $row['total'];
		$new_code = $total_rows + 1;
		$Номер_покупателя = $new_code;

		if (empty($_POST['fullname']) || empty($_POST['login']) || empty($_POST['password'])) {
			echo "Не все поля заполнены";
		} else {
			$sql = "INSERT INTO покупатели (Номер_покупателя, ФИО, Логин, Пароль) VALUES (?, ?, ?, ?)";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("ssss", $Номер_покупателя, $_POST['fullname'], $_POST['login'], $_POST['password']);
			$stmt->execute();
			$stmt->close();
			echo "Пользователь зарегистрирован<br>";
			sleep(2);
			header("Location: index.php");
		}
	 }
	 ?>
</body>
</html>