<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="style.css" type="text/css" rel="stylesheet">
	<title>Лабораторна работа 7</title>
   <script src = "utils.js"></script>
</head>

<?php include("bd.php");?>

<body>
   <h3>Таблица производителей:</h3>
   <input type="submit" value="Search" onclick=func1()>

   <h3>Таблица товаров отсутствующих на складе</h3>
    <input type="submit" value="Search" onclick=func2()>

   <h3>Выберите ценовой диапазон:</h3>
    <?php echo gen_price_range(); ?>
    <input type="submit" value="Search" onclick=func3()>
  
   <p>RESULTS:</p>
   <div id="content"></div>

</body> 
</html>

