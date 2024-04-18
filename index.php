<!DOCTYPE html>
<html lang="ru";

<?php 
	include 'connect.php';
?>

<head>
	<meta charset="UNT-8">
	<link rel="stylesheet" href="style.css">
	<title>Интернет-магазин автозапчастей</title>
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

	 <h1 align=center>Добро пожаловать в наш интернет магазин автозапчастей! </h1>
	 <p align=center>На нашем сайте вы можете подобрать различные комплектующие для Вашего автомобиля.</p>
	 <p align=center>В нашей базе данных вы сможете выбрать подходящий Вам товар, свереть его по описанию и заказать.</p>
	 <p align=center>Ассортимент запчастей регулярно обновляется и Вы обязательно найдёте здесь что-то подходящее для себя!</p>
	 <p align=center>Спасибо, что выбрали нас! Удачи на дорогах!</p>

</body>
</html>
