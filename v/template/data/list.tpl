<div id="display" class="data">
<?php

if(!empty($datas)){
	?>
	<div class="hrow">
		<div class="login"><a>Логин</a></div>
		<div class="service"><a>Service</a></div>
		<div class="gender"><a>Gender</a></div>
		<div class="top"><a>TOP</a></div>
		<div class="date"><a>Модиф.</a></div>
		<div class="active"><a>Включен</a></div>
		<div class="action"></div>
	</div>
	<?php
	foreach($datas AS $row){
	?>
		<!-- -->
		<div class="srow">
			<div class="login"><a><?=$row["login"]?></a></div>
			<div class="service"><a><?=$row["service"]?></a></div>
			<div class="gender"><a><?=$row["gender"]?></a></div>
			<div class="top"><a><?=$row["top"]?></a></div>
			<div class="date"><a><?=$row["date"]?></a></div>
			<div class="active"><a style="color: <?=$row["style"]?>;"><?=$row["active"]?></a></div>
			<div class="action"><?=$row["action"]["edit"]?> | <?=$row["action"]["del"]?></div>
		</div>
		<!-- -->
	<?php
	}
}
else
{
?>
	<!-- -->
	<a class="empty">Данных нет</a>
	<!-- -->
<?php
}
?>
</div>