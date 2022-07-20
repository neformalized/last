<div id="display" class="form">

	<form action="<?=$formAction?>" method="POST">
		
		<div class="part"><div>
		
			<a>Название</a>
			<input type="text" name="name" value="<?=!empty($_POST["name"]) ? $_POST["name"] : "" ; ?>">
			<a>Дубли</a>
			<select name="function" class="width">
				<option value="clone"<?=(!empty($_POST["function"]) && $_POST["function"] == "clone") ? " selected" : "" ;?>>Создать _клон модели</option>
				<option value="replace"<?=(!empty($_POST["function"]) && $_POST["function"] == "replace") ? " selected" : "" ;?>>Заменить модель</option>
				<option value="append"<?=(!empty($_POST["function"]) && $_POST["function"] == "append") ? " selected" : "" ;?>>Обновить найденные поля</option>
				<option value="pass"<?=(!empty($_POST["function"]) && $_POST["function"] == "pass") ? " selected" : "" ;?>>Ничего не делать</option>
			</select>
			<a>Парсер</a>
			<select name="parser" class="width">
				<option></option>
				<?php
				if(!empty($parsers)){
					foreach($parsers AS $parser){
						?>
						<option value="<?=$parser["_id"]?>"<?=isset($_POST["parser"]) && $_POST["parser"] == $parser["_id"] ? " selected" : "" ?>><?=$parser["name"]?></option>
						<?php
					}
				}
				?>
			</select>
			<a>Тригер</a>
			<select name="trigger" class="width">
				<option></option>
				<?php
				if(!empty($triggers)){
					foreach($triggers AS $trigger){
						?>
						<option value="<?=$trigger["_id"]?>"<?=isset($_POST["trigger"]) && $_POST["trigger"] == $trigger["_id"] ? " selected" : "" ?>><?=$trigger["name"]?></option>
						<?php
					}
				}
				?>
			</select>
		
		</div></div>
		
		<div class="part"><div>
		
			<a>Параметры</a>
			<div id="params">
			<?php
			if(!empty($params)){
				foreach($params AS $param){
					?>
					<div class="param">
						<a>Param <font onclick="delParam(this);">del</font></a>
						<input type="text" name="params[]" value="<?=$param["key"]?>"><!--
					 --><input type="text" name="values[]" value="<?=$param["value"]?>">
					</div>
					<?php
				}
			}
			?>
			</div>
			
			<div id="add" onclick="addParam();">
				<a>добавить</a>
			</div>
			
		</div></div>
		
		<div class="part"><div>
		
			<a>Прокси обязательны</a>
			<select name="proxyOnly">
				<option value="no"<?=(!empty($_POST["proxyOnly"]) && $_POST["proxyOnly"] == "no") ? " selected" : "" ;?>>нет</option>
				<option value="yes"<?=(!empty($_POST["proxyOnly"]) && $_POST["proxyOnly"] == "yes") ? " selected" : "" ;?>>да</option>
			</select>
			<a>Прокси</a>
			<select name="proxy[]" multiple>
				<?php
				print_r($_POST["proxy"]);
				if(isset($proxyes) && !empty($proxyes)){
					foreach($proxyes AS $proxy){
						?>
						<option value="<?=$proxy["_id"]?>"<?=isset($_POST["proxy"]) && in_array($proxy["_id"], $_POST["proxy"]) ? " selected" : "" ?>><?=$proxy["name"]?></option>
						<?php
					}
				}
				?>
			</select>
			
		</div></div>
		
		<div class="part black"><div>
		
			<a>Min</a>
			<input type="text" name="min" value="<?=!empty($_POST["min"]) ? $_POST["min"] : "1" ; ?>">
			<a>Hour</a>
			<input type="text" name="hour" value="<?=!empty($_POST["hour"]) ? $_POST["hour"] : "*" ; ?>">
			<a>Day</a>
			<input type="text" name="day" value="<?=!empty($_POST["day"]) ? $_POST["day"] : "*" ; ?>">
			<a>Month</a>
			<input type="text" name="month" value="<?=!empty($_POST["month"]) ? $_POST["month"] : "*" ; ?>">
			<a>Weekday</a>
			<input type="text" name="weekday" value="<?=!empty($_POST["weekday"]) ? $_POST["weekday"] : "*" ; ?>">
		
		</div></div>
		
		<div class="clear"></div>
		
		<input type="submit" value="go">
		
	</form>

</div>