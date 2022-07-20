<div id="display" class="form">

	<form action="<?=$formAction?>" method="POST">
	
		<div class="main">
			<a>Логин</a>
			<input type="text" name="login" value="<?=!empty($_POST["login"]) ? $_POST["login"] : "" ; ?>">
			<a>Service</a>
			<input type="text" name="service" value="<?=!empty($_POST["service"]) ? $_POST["service"] : "" ; ?>">
			<a>Топ</a>
			<input type="text" name="top" value="<?=!empty($_POST["top"]) ? $_POST["top"] : "" ; ?>">
			<a>Включен</a>
			<select name="active">
					<option value="no" <?=(!empty($_POST["active"]) && $_POST["active"] == "no") ? "selected" : "" ;?>>Нет</option>
					<option value="yes" <?=(!empty($_POST["active"]) && $_POST["active"] == "yes") ? "selected" : "" ;?>>Да</option>
			</select>
		</div>
		
		<input type="submit" value="go">
		
		<div class="field">
		
			<div>
				<b>extid<font>int</font></b>
				<input type="text" name="extid" value="<?=!empty($_POST["extid"]) ? $_POST["extid"] : "" ; ?>">
			</div>
			
			<div>
				<b>status<font>string</font></b>
				<input type="text" name="status" value="<?=!empty($_POST["status"]) ? $_POST["status"] : "" ; ?>">
			</div>
			
			<div>
				<b>username<font>string</font></b>
				<input type="text" name="username" value="<?=!empty($_POST["username"]) ? $_POST["username"] : "" ; ?>">
			</div>
			
			<div>
				<b>displayname<font>string</font></b>
				<input type="text" name="displayname" value="<?=!empty($_POST["displayname"]) ? $_POST["displayname"] : "" ; ?>">
			</div>
			
			<div>
				<b>platform<font>(a)string</font></b>
				<input type="text" name="platform" value="<?=!empty($_POST["platform"]) ? $_POST["platform"] : "" ; ?>">
			</div>
			
			<div class="rate">
				<b>rate<font>int</font></b>
				<input type="text" name="rate" value="<?=!empty($_POST["rate"]) ? $_POST["rate"] : "" ; ?>">
			</div>
			
			<div>
				<b>new<font>boolean</font></b>
				<select name="new">
					<option></option>
					<option value="false" <?=(!empty($_POST["new"]) && $_POST["new"] == "false") ? "selected" : "" ;?>>false</option>
					<option value="true" <?=(!empty($_POST["new"]) && $_POST["new"] == "true") ? "selected" : "" ;?>>true</option>
				</select>
			</div>
			
			<div>
				<b>gender<font>string</font></b>
				<input type="text" name="gender" value="<?=!empty($_POST["gender"]) ? $_POST["gender"] : "" ; ?>">
			</div>
			
			<div>
				<b>birth<font>date</font></b>
				<input type="text" name="birth" value="<?=!empty($_POST["birth"]) ? $_POST["birth"] : "" ; ?>">
			</div>
			
			<div>
				<b>age<font>int</font></b>
				<input type="text" name="age" value="<?=!empty($_POST["age"]) ? $_POST["age"] : "" ; ?>">
			</div>
			
			<div>
				<b>lang<font>(a)string</font></b>
				<input type="text" name="lang" value="<?=!empty($_POST["lang"]) ? $_POST["lang"] : "" ; ?>">
			</div>
			
			<div>
				<b>sublang<font>(a)string</font></b>
				<input type="text" name="sublang" value="<?=!empty($_POST["sublang"]) ? $_POST["sublang"] : "" ; ?>">
			</div>
			
			<div>
				<b>country<font>string</font></b>
				<input type="text" name="country" value="<?=!empty($_POST["country"]) ? $_POST["country"] : "" ; ?>">
			</div>
			
			<div>
				<b>hiddenregions<font>(a)int</font></b>
				<input type="text" name="hiddenregions" value="<?=!empty($_POST["hiddenregions"]) ? $_POST["hiddenregions"] : "" ; ?>">
			</div>
			
			<div>
				<b>tags<font>(a)string</font></b>
				<input type="text" name="tags" value="<?=!empty($_POST["tags"]) ? $_POST["tags"] : "" ; ?>">
			</div>
			
			<div>
				<b>desc<font>string</font></b>
				<input type="text" name="desc" value="<?=!empty($_POST["desc"]) ? $_POST["desc"] : "" ; ?>">
			</div>
			
			<div class="img">
				<b>ava(only filename)<font>string</font></b>
				<input type="text" name="ava" value="<?=!empty($_POST["ava"]) ? $_POST["ava"] : "" ; ?>">
			</div>
			
			<div class="img">
				<b>snap<font>string</font></b>
				<input type="text" name="snap" value="<?=!empty($_POST["snap"]) ? $_POST["snap"] : "" ; ?>">
			</div>
			
			<div class="img">
				<b>prevs<font>(a)string</font></b>
				<input type="text" name="prevs" value="<?=!empty($_POST["prevs"]) ? $_POST["prevs"] : "" ; ?>">
			</div>
			
			<div>
				<b>starttime<font>string</font></b>
				<input type="text" name="starttime" value="<?=!empty($_POST["starttime"]) ? $_POST["starttime"] : "" ; ?>">
			</div>
			
			<div>
				<b>quality<font>(a)string</font></b>
				<input type="text" name="quality" value="<?=!empty($_POST["quality"]) ? $_POST["quality"] : "" ; ?>">
			</div>
			
			<div>
				<b>mobile<font>boolean</font></b>
				<select name="mobile">
					<option></option>
					<option value="false" <?=(!empty($_POST["mobile"]) && $_POST["mobile"] == "false") ? "selected" : "" ;?>>false</option>
					<option value="true" <?=(!empty($_POST["mobile"]) && $_POST["mobile"] == "true") ? "selected" : "" ;?>>true</option>
				</select>
			</div>
			
			<div>
				<b>toy<font>boolean</font></b>
				<select name="toy">
					<option></option>
					<option value="false" <?=(!empty($_POST["toy"]) && $_POST["toy"] == "false") ? "selected" : "" ;?>>false</option>
					<option value="true" <?=(!empty($_POST["toy"]) && $_POST["toy"] == "true") ? "selected" : "" ;?>>true</option>
				</select>
			</div>
			
			<div>
				<b>url<font>string</font></b>
				<input type="text" name="url" value="<?=!empty($_POST["url"]) ? $_POST["url"] : "" ; ?>">
			</div>
			
			<div>
				<b>ethnic<font>string</font></b>
				<input type="text" name="ethnic" value="<?=!empty($_POST["ethnic"]) ? $_POST["ethnic"] : "" ; ?>">
			</div>
			
			<div>
				<b>eyes<font>string</font></b>
				<input type="text" name="eyes" value="<?=!empty($_POST["eyes"]) ? $_POST["eyes"] : "" ; ?>">
			</div>
			
			<div>
				<b>hair<font>string</font></b>
				<input type="text" name="hair" value="<?=!empty($_POST["hair"]) ? $_POST["hair"] : "" ; ?>">
			</div>
			
			<div>
				<b>height<font>string</font></b>
				<input type="text" name="height" value="<?=!empty($_POST["height"]) ? $_POST["height"] : "" ; ?>">
			</div>
			
			<div>
				<b>body<font>string</font></b>
				<input type="text" name="body" value="<?=!empty($_POST["body"]) ? $_POST["body"] : "" ; ?>">
			</div>
			
			<div>
				<b>a<font>string</font></b>
				<input type="text" name="a" value="<?=!empty($_POST["a"]) ? $_POST["b"] : "" ; ?>">
			</div>
			
			<div>
				<b>b<font>string</font></b>
				<input type="text" name="b" value="<?=!empty($_POST["b"]) ? $_POST["b"] : "" ; ?>">
			</div>
			
			<div>
				<b>ptype<font>string</font></b>
				<input type="text" name="ptype" value="<?=!empty($_POST["ptype"]) ? $_POST["ptype"] : "" ; ?>">
			</div>
			
			<div>
				<b>sizec<font>string</font></b>
				<input type="text" name="sizec" value="<?=!empty($_POST["sizec"]) ? $_POST["sizec"] : "" ; ?>">
			</div>
			
			<div>
				<b>cutted<font>boolean</font></b>
				<select name="cutted">
					<option></option>
					<option value="false" <?=(!empty($_POST["cutted"]) && $_POST["cutted"] == "false") ? "selected" : "" ;?>>false</option>
					<option value="true" <?=(!empty($_POST["cutted"]) && $_POST["cutted"] == "true") ? "selected" : "" ;?>>true</option>
				</select>
			</div>
		
		</div>
		
		<input type="submit" value="go">
		
	</form>
	
</div>