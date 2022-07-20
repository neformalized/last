<div id="display" class="parser">
<?php
if(!empty($parser)){
	?>
	<div class="hrow">
		<div class="name"><a>Название</a></div>
		<div class="type"><a>Тип</a></div>
		<div class="link"><a>Link</a></div>
		<div class="active"><a>Включен</a></div>
		<div class="action"></div>
	</div>
	<?php
	foreach($parser AS $row){
	?>
		<!-- -->
		<div class="srow">
			<div class="name"><a><?=$row["name"]?></a></div>
			<div class="type"><a><?=$row["type"]?></a></div>
			<div class="link"><a><?=$row["link"]?></a></div>
			<div class="active"><a style="color: <?=$row["style"]?>;"><?=$row["active"]?></a></div>
			<div class="action"><?=$row["action"]["edit"]?> | <?=$row["action"]["delete"]?></div>
		</div>
		<!-- -->
	<?php
	}
}
else
{
?>
	<!-- -->
	<a class="empty">Парсеров нет</a>
	<!-- -->
<?php
}
?>
</div>