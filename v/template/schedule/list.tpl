<div id="display" class="schedule">
<?php
if(!empty($schedule)){
	?>
	<div class="hrow">
		<div class="name"><a>Название</a></div>
		<div class="parser"><a>Парсер</a></div>
		<div class="trigger"><a>Триггер</a></div>
		<div class="proxy"><a>Прокси*</a></div>
		<div class="cr"><a>min</a></div>
		<div class="cr"><a>hour</a></div>
		<div class="cr"><a>day</a></div>
		<div class="cr"><a>month</a></div>
		<div class="cr"><a>wday</a></div>
		<div class="active"><a>croned</a></div>
		<div class="action"></div>
	</div>
	<?php
	foreach($schedule AS $row){
	?>
		<!-- -->
		<div class="srow">
			<div class="name"><a><?=$row["name"]?></a></div>
			<div class="parser"><a><?=$row["parser"]?></a></div>
			<div class="trigger"><a><?=$row["trigger"]?></a></div>
			<div class="proxy" style="color: <?=$row["style"]?>;"><a><?=$row["proxy"]?></a></div>
			<div class="cr"><a><?=$row["cron"]["min"]?></a></div>
			<div class="cr"><a><?=$row["cron"]["hour"]?></a></div>
			<div class="cr"><a><?=$row["cron"]["day"]?></a></div>
			<div class="cr"><a><?=$row["cron"]["month"]?></a></div>
			<div class="cr"><a><?=$row["cron"]["weekday"]?></a></div>
			<div class="active"><a><?=$row["status"]?></a></div>
			<div class="action"><?=$row["action"]["edit"]?> | <?=$row["action"]["execute"]?> | <?=$row["action"]["delete"]?></div>
		</div>
		<!-- -->
	<?php
	}
}
else
{
?>
	<!-- -->
	<a class="empty">Планировок нет</a>
	<!-- -->
<?php
}
?>
</div>