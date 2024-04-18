<?php include 'connect.php' ?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style.css">
	<title>Интернет-Магазин автозапчастей - ЛК</title>
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

	 <h2>Личный кабинет</h2>
	 <?php
	 session_start();
	 echo "код пользователя = ".$_SESSION['code'];
	 $filter = isset($_SESSION['code']) ? " WHERE Номер_покупателя = '" . $_SESSION['code'] . "'" : "";
	 $sql_ = "SELECT * FROM покупатели" . $filter;
	 $resu = $conn->query($sql_);

	 if ($resu->num_rows > 0) {
		echo "<table>";
		echo "<tr><th>ФИО</th><th>Логин</th><th>Пароль</th></tr>";
		while ($row = $resu->fetch_assoc()) {
			echo "<tr><td>" . $row['ФИО'] . "</td><td>" . $row['Логин'] . "</td><td>" . $row['Пароль'] . "</td></tr>";
		}
		echo "</table>";
	 } else { echo "Пользователь не авторизован"; }

	 // Обработка событий для кнопки "изменить"
	 if(isset($_POST['update'])) {
		 $code = $_SESSION['code'];
		 $full_name = $_POST['Имя_покупателя'];
		 $login = $_POST['Логин'];
		 $password = $_POST['Пароль'];
		 $update_query = "UPDATE покупатели SET ФИО = '$full_name', Логин = '$login', Пароль = '$password' WHERE Номер_покупателя = '$code'";
		 $result_update = $conn->query($update_query);
		 if($result_update) {
			echo "Данные успешно обновлены.";
		 } else {
			echo "Ошибка при обновлении данных.";
		 }
	}
	?>

	<h2>Изменить данные</h2>
	<form method="post">
	<table>
	<th>Название</th>
	<th>Введите данные</th>
	<tr><td>ФИО</td><td><input type="text" name="Имя_покупателя" value="<?php echo $row['Имя_покупателя']; ?>"> </td></tr>
	<tr><td><br>Логин</td><td><input type="text" name="Логин" value="<?php echo $row['Логин']; ?>">
	</td></tr>
	<tr><td><br>Пароль</td><td><input type="text" name="Пароль" value="<?php echo $row['Пароль'];
	?>">
	</td></tr>
	</table>
	<br><input type="submit" class="button" name="update" value="Изменить">
	</form>

	<h2>Купленные запчасти</h2>
	<?php

	$sql_hist = "SELECT детали.название AS Название, заказ.Дата AS Дата
					FROM заказ
					JOIN детали ON заказ.Серийный_номер = детали.Серийный_номер
					WHERE заказ.номер_покупателя = '" .$_SESSION['code']. "'";

	$result_hist = $conn->query($sql_hist);
	if ($result_hist->num_rows > 0) {
	 echo "<table>";
	 echo "<tr><th>Детали</th><th>Дата покупки</th></tr>";
	 while ($row = $result_hist->fetch_assoc()) {
		echo "<tr><td>" . $row['Название'] . "</td><td>" . $row['Дата'] . "</td></tr>";
	 }
		echo "</table>";
	} else {
		 echo "Нет данных для отображения.";
	}
	$conn->close();
	?>