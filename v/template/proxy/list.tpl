<div id="display" class="proxy">
<?php
if(!empty($proxy)){
	?>
	<div class="hrow">
		<div class="name"><a>Название</a></div>
		<div class="ip"><a>Ип</a></div>
		<div class="port"><a>Порт</a></div>
		<div class="type"><a>Тип</a></div>
		<div class="last"><a>Последняя акт.</a></div>
		<div class="active"><a>Включен</a></div>
		<div class="action"></div>
	</div>
	<?php
	foreach($proxy AS $row){
	?>
		<!-- -->
		<div class="srow">
			<div class="name"><a><?=$row["name"]?></a></div>
			<div class="ip"><a><?=$row["ip"]?></a></div>
			<div class="port"><a><?=$row["port"]?></a></div>
			<div class="type"><a><?=$row["type"]?></a></div>
			<div class="last"><a><?=$row["last"]?></a></div>
			<div class="active"><a style="color: <?=$row["style"]?>;"><?=$row["active"]?></a></div>
			<div class="action"><?=$row["action"]["edit"]?> | <?=$row["action"]["delete"]?> | <?=$row["action"]["fresh"]?></div>
		</div>
		<!-- -->
	<?php
	}
}
else
{
?>
	<!-- -->
	<a class="empty">Прокси нет</a>
	<!-- -->
<?php
}
?>
</div>