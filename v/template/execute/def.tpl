<div id="display" class="execute">
	<?php if(isset($new)) { ?> <div><a>Добавлено - </a><b><?=$new?></b></div> <?php } ?>
	<?php if(isset($func) && $func > 0) { ?> <div><a><?=$func_name?> - </a><b><?=$func?></b></div> <?php } ?>
	<?php if(isset($corrupted)) { ?> <div><a>Потеряно - </a><b><?=$corrupted?></b></div> <?php } ?>
</div>