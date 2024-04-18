<?php include 'connect.php' ?>

<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<title>Интернет-магазин автозапчастей - покупки</title>
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

	 <?php
	 $sort = isset($_POST['sort']) ? $_POST['sort'] : "DESC";
     $sql = "SELECT * FROM Детали ORDER BY Серийный_номер $sort";
     $result = $conn->query($sql);

	 if ($result->num_rows > 0) {
		 if (isset($_SESSION['code']) && !empty($_SESSION['code'])) {
			 echo "<br><table border='2'>";
					echo "<tr><th>Серийный_номер</th><th>Название</th><th>Цена, ₽</th><th>Купить</th>";
					while ($row = $result->fetch_assoc()) {
						 echo "<tr>";
						 echo "<td>" . $row["Серийный_номер"] . "</td>";
						 echo "<td>" . $row["Название"] . "</td>";
						 echo "<td>" . $row["Цена"] . "</td>";
						 // Выводим кнопку 'Купить'
						 echo "<td><form method='post' action='' onsubmit='return добавитьПокупателя()'>";
						 echo "<input type='hidden' name='code' value='" . $row['Серийный_номер'] . "'>";
						 echo "<input type='hidden' name='customerCode' value='" . $_SESSION['code'] . "'>"; // Добавляем код покупателя из сессии
						 echo "<button method='post' type='submit' name='buy'>Купить</button></form></td></tr>";
						 echo "</tr>";
					}
			 echo "</table></br>";
		 } else {
		echo "<h1 style='text-align: center;'>Чтобы приобрести товар необходимо авторизироваться</h1>;
";
	 }

	 if ($_SERVER["REQUEST_METHOD"] == "POST") {
		 $count_query = "SELECT COUNT(*) as totalq FROM заказ";
		 $result_q = $conn->query($count_query);
		 $row = $result_q->fetch_assoc();
		 $total_rows = $row['totalq'];
		 $new_code = $total_rows + 1;
		 $num_zakaz = $new_code;
		
		 $code_det = $_POST['code'];
		 $customerCode = $_SESSION['code'];
		 $date = date('Y-m-d H:i:s', time());
		 $sql = "INSERT INTO заказ (Номер_заказа, Дата, Номер_покупателя, Серийный_номер) VALUES ('$num_zakaz', '$date', '$customerCode', '$code_det')";
		 // Выполняем SQL запрос
		 if ($conn->query($sql) === TRUE) {
			echo "Строка успешно добавлена в таблицу заказа.";
		 } else {
			echo "Ошибка: " . $sql . "<br>" . $conn->error;
		 }
		 
	}
// Закрываем соединение с базой данных
$conn->close();

}
?>
