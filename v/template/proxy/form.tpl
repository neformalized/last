<div id="display" class="form">

	<form action="<?=$formAction?>" method="POST">
		
		<div class="main">
		
			<a>Название</a>
			<input type="text" name="name" value="<?=!empty($_POST["name"]) ? $_POST["name"] : "" ; ?>">
			<a>Ип</a>
			<input type="text" name="ip" value="<?=!empty($_POST["ip"]) ? $_POST["ip"] : "" ; ?>">
			<a>Порт</a>
			<input type="text" name="port" value="<?=!empty($_POST["port"]) ? $_POST["port"] : "" ; ?>">
			<a>Тип</a>
			<select name="type">
				<option value="http" <?=(!empty($_POST["type"]) && $_POST["type"] == "http") ? "selected" : "" ;?>>http</option>
				<option value="https" <?=(!empty($_POST["type"]) && $_POST["type"] == "https") ? "selected" : "" ;?>>https</option>
				<option value="socks" <?=(!empty($_POST["type"]) && $_POST["type"] == "socks") ? "selected" : "" ;?>>socks</option>
			</select>
			<a>Логин</a>
			<input type="text" name="login" value="<?=!empty($_POST["login"]) ? $_POST["login"] : "" ; ?>">
			<a>Пароль</a>
			<input type="text" name="pass" value="<?=!empty($_POST["pass"]) ? $_POST["pass"] : "" ; ?>">
		
		</div>
		
		<input type="submit" value="go">
		
	</form>

</div>