<!DOCTYPE html>
<head>
<meta charset="utf8">
<title>Agregator &bull; <?=$title?></title>
<link rel="stylesheet" href="v/style.css">
<link rel="stylesheet" href="v/font.css">
<?php
if(!empty($scripts)) foreach($scripts AS $script) echo $script;
?>
</head>
<body>

<div id="wrap"><div>
		
	<div id="dash"><div>
		<a href="/thecam/?controller=api" class="api">API</a>
		<a href="/thecam/?controller=schedule" class="schedule">Планировщик</a>
		<a href="/thecam/?controller=parser" class="parser">Парсер</a>
		<a href="/thecam/?controller=data" class="data">Данные</a>
		<a href="/thecam/?controller=proxy" class="proxy">Прокси</a>
	</div></div>

<div id="frame"><div>

<!-- -->

<div id="bread">
<?php
foreach($bread AS $row) echo $row;
?>
</div>

<!-- -->

<?php

if(isset($success)){
	foreach($success AS $row){
	?>
	<!-- -->
	
	<a class="success"><?=$row?></a>
	
	<!-- -->
	<?php
	}
}

if(isset($error)){
	foreach($error AS $row){
	?>
	<!-- -->
	
	<a class="error"><?=$row?></a>
	
	<!-- -->
	<?php
	}
}

if(isset($attention)){
	foreach($attention AS $row){
	?>
	<!-- -->
	
	<a class="attention"><?=$row?></a>
	
	<!-- -->
	<?php
	}
}

if(isset($warning)){
	foreach($warning AS $row){
	?>
	<!-- -->
	
	<a class="warning"><?=$row?></a>
	
	<!-- -->
	<?php
	}
}

?>