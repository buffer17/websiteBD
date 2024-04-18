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

	 <?php
        $phone = "+79819799147";
        $email = "Rautmazar@mail.ru";
        $vk = "https://vk.com/mazaraut";

        echo "<table>
                <tr>
                    <td>Телефон:</td>
                    <td><a href='tel:$phone'>$phone</a></td>
                </tr>
                <tr>
                    <td>Почта:</td>
                    <td><a href='mailto:$email'>$email</a></td>
                </tr>
                <tr>
                    <td>ВКонтакте:</td>
                    <td><a href='$vk'>$vk</a></td>
                </tr>
            </table>";
     ?>

</body>
</html>

