<div id="display" class="api">
<?php
if(!empty($api)){
	?>
	<div class="hrow">
		<div class="name"><a>Название</a></div>
		<div class="service"><a>Service</a></div>
		<div class="limit"><a>Limit</a></div>
		<div class="active"><a>Включен</a></div>
		<div class="action"></div>
	</div>
	<?php
	foreach($api AS $row){
	?>
		<!-- -->
		<div class="srow">
			<div class="name"><a><?=$row["name"]?></a></div>
			<div class="service"><a><?=$row["service"]?></a></div>
			<div class="limit"><a><?=$row["limit"]?></a></div>
			<div class="active"><a style="color: <?=$row["style"]?>;"><?=$row["active"]?></a></div>
			<div class="action"><?=$row["action"]["edit"]?> | <?=$row["action"]["del"]?> | <?=$row["action"]["backend"]?></div>
		</div>
		<!-- -->
	<?php
	}
}
else
{
?>
	<!-- -->
	<a class="empty">Api нет</a>
	<!-- -->
<?php
}
?>
</div>