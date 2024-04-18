<?php include 'connect.php' ?>

<!DOCTYPE html>
<thml lang="ru";
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style.css">
	<title>Интернет-Магазин автозапчастей</title>
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

    <form method="post">
          <label for="filter_ser">Поиск по серийному номеру:</label>
          <input type="number" name="filter_ser" required>
          <input class="submit" type="submit" name="filter" value="Применить фильтр">
    </form>

    <form method="get">
          <label for="clear_list"></label>
          <input class="submit" type="submit" name="clear" value="Сброс">
    </form>

  <?php
  if (isset($_GET['clear'])) { $bool_filt = False; }
  if (isset($_POST['filter'])) {
    $filter_ser = $_POST['filter_ser'];
  
    $sql = "SELECT детали.*, поставщик.Название AS Номер_поставщика
            FROM детали
            JOIN поставщик ON детали.Номер_поставщика = поставщик.Номер_поставщика
            WHERE Серийный_номер = '$filter_ser'";
    $result = $conn->query($sql);
    $bool_filt = True;
  } else if ($bool_filt == False) {

    $sql = "SELECT детали.*, поставщик.Название AS Номер_поставщика
            FROM детали
            JOIN поставщик ON детали.Номер_поставщика = поставщик.Номер_поставщика";
    $result = $conn->query($sql);
  }

    if ($result->num_rows > 0) {

         echo "<br><table border='2'>";
                echo "<tr><th>Серийный_номер</th><th>Название</th><th>Цена, ₽</th><th>Поставщик</th><th>Фото</th>";
                while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["Серийный_номер"] . "</td>";
                echo "<td>" . $row["Название"] . "</td>";
                echo "<td>" . $row["Цена"] . "</td>";
                echo "<td>" . $row["Номер_поставщика"] . "</td>";
                $row["Фото"] = $row["Серийный_номер"];
                echo "<td> <img src='".$row['Фото'].".jpg' width=100 height=100></td></tr>";
                echo "</tr>";
        }
        echo "</table></br>";
    } else {
        echo "0 results";
    }
    
  ?>

</body>
</html>