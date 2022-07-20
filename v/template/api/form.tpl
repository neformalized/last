<div id="display" class="form">

	<form action="<?=$formAction?>" method="POST">
	
		<div class="main">
			<a>Название</a>
			<input type="text" name="name" value="<?=!empty($_POST["name"]) ? $_POST["name"] : "" ; ?>">
			<a>Service</a>
			<input type="text" name="service" value="<?=!empty($_POST["service"]) ? $_POST["service"] : "" ; ?>">
			<a>Limit (>0)</a>
			<input type="text" name="limit" value="<?=!empty($_POST["limit"]) ? $_POST["limit"] : "" ; ?>">
			<a>Кешировать(сек)</a>
			<input type="text" name="cache" value="<?=!empty($_POST["cache"]) ? $_POST["cache"] : "" ; ?>">
			<a>Включен</a>
			<select name="active">
					<option value="no" <?=(!empty($_POST["active"]) && $_POST["active"] == "no") ? "selected" : "" ;?>>Нет</option>
					<option value="yes" <?=(!empty($_POST["active"]) && $_POST["active"] == "yes") ? "selected" : "" ;?>>Да</option>
			</select>
		</div>
		
		<input type="submit" value="go">
		
		<div class="field">
		
			<div>
				<b>extid <input type="checkbox" name="extid_project" value="1"<?=(isset($_POST["extid_project"]) && $_POST["extid_project"] == "1") ? " checked" : "" ; ?>><font>int</font></b>
			</div>
			
			<div>
				<b>status <input type="checkbox" name="status_project" value="1"<?=(isset($_POST["status_project"]) && $_POST["status_project"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>LIKE</a>
				<input type="text" name="status_condition" value="<?=!empty($_POST["status_condition"]) ? $_POST["status_condition"] : "" ; ?>">
			</div>
			
			<div>
				<b>username <input type="checkbox" name="username_project" value="1"<?=(isset($_POST["username_project"]) && $_POST["username_project"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
			</div>
			
			<div>
				<b>displayname <input type="checkbox" name="displayname_project" value="1"<?=(isset($_POST["displayname_project"]) && $_POST["displayname_project"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
			</div>
			
			<div>
				<b>platform <input type="checkbox" name="platform_project" value="1"<?=(isset($_POST["platform_project"]) && $_POST["platform_project"] == "1") ? " checked" : "" ; ?>><font>(a)string</font></b>
				<a>LIKE,S</a>
				<input type="text" name="platform_condition" value="<?=!empty($_POST["platform_condition"]) ? $_POST["platform_condition"] : "" ; ?>">
			</div>
			
			<div class="rate">
				<b>rate<input type="checkbox" name="rate_project" value="1"<?=(isset($_POST["rate_project"]) && $_POST["rate_project"] == "1") ? " checked" : "" ; ?>><font>int</font></b>
				<a>></a>
				<input type="text" name="rate_condition_a" value="<?=!empty($_POST["rate_condition_a"]) ? $_POST["rate_condition_a"] : "" ; ?>">
				<a><</a>
				<input type="text" name="rate_condition_b" value="<?=!empty($_POST["rate_condition_b"]) ? $_POST["rate_condition_b"] : "" ; ?>">
			</div>
			
			<div>
				<b>new <input type="checkbox" name="new_project" value="1"<?=(isset($_POST["new_project"]) && $_POST["new_project"] == "1") ? " checked" : "" ; ?>><font>boolean</font></b>
				<a>==</a>
				<select name="new_condition">
					<option></option>
					<option value="false" <?=(!empty($_POST["new_condition"]) && $_POST["new_condition"] == "false") ? "selected" : "" ;?>>false</option>
					<option value="true" <?=(!empty($_POST["new_condition"]) && $_POST["new_condition"] == "true") ? "selected" : "" ;?>>true</option>
				</select>
			</div>
			
			<div>
				<b>gender <input type="checkbox" name="gender_project" value="1"<?=(isset($_POST["gender_project"]) && $_POST["gender_project"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>LIKE</a>
				<input type="text" name="gender_condition" value="<?=!empty($_POST["gender_condition"]) ? $_POST["gender_condition"] : "" ; ?>">
			</div>
			
			<div>
				<b>birth <input type="checkbox" name="birth_project" value="1"<?=(isset($_POST["birth_project"]) && $_POST["birth_project"] == "1") ? " checked" : "" ; ?>><font>date</font></b>
			</div>
			
			<div>
				<b>age <input type="checkbox" name="age_project" value="1"<?=(isset($_POST["age_project"]) && $_POST["age_project"] == "1") ? " checked" : "" ; ?>><font>int</font></b>
				<a>></a>
				<input type="text" name="age_condition_a" value="<?=!empty($_POST["age_condition_a"]) ? $_POST["age_condition_a"] : "" ; ?>">
				<a><</a>
				<input type="text" name="age_condition_b" value="<?=!empty($_POST["age_condition_b"]) ? $_POST["age_condition_b"] : "" ; ?>">
			</div>
			
			<div>
				<b>lang <input type="checkbox" name="lang_project" value="1"<?=(isset($_POST["lang_project"]) && $_POST["lang_project"] == "1") ? " checked" : "" ; ?>><font>(a)string</font></b>
				<a>LIKE,S</a>
				<input type="text" name="lang_condition" value="<?=!empty($_POST["lang_condition"]) ? $_POST["lang_condition"] : "" ; ?>">
			</div>
			
			<div>
				<b>sublang <input type="checkbox" name="sublang_project" value="1"<?=(isset($_POST["sublang_project"]) && $_POST["sublang_project"] == "1") ? " checked" : "" ; ?>><font>(a)string</font></b>
				<a>LIKE,S</a>
				<input type="text" name="sublang_condition" value="<?=!empty($_POST["sublang_condition"]) ? $_POST["sublang_condition"] : "" ; ?>">
			</div>
			
			<div>
				<b>country <input type="checkbox" name="country_project" value="1"<?=(isset($_POST["country_project"]) && $_POST["country_project"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>LIKE</a>
				<input type="text" name="country_condition" value="<?=!empty($_POST["country_condition"]) ? $_POST["country_condition"] : "" ; ?>">
			</div>
			
			<div>
				<b>hiddenregions <input type="checkbox" name="hiddenregions_project" value="1"<?=(isset($_POST["hiddenregions_project"]) && $_POST["hiddenregions_project"] == "1") ? " checked" : "" ; ?>><font>(a)int</font></b>
				<a>==,</a>
				<input type="text" name="hiddenregions_condition" value="<?=!empty($_POST["hiddenregions_condition"]) ? $_POST["hiddenregions_condition"] : "" ; ?>">
			</div>
			
			<div>
				<b>tags <input type="checkbox" name="tags_project" value="1"<?=(isset($_POST["tags_project"]) && $_POST["tags_project"] == "1") ? " checked" : "" ; ?>><font>(a)string</font></b>
				<a>LIKE,S</a>
				<input type="text" name="tags_condition" value="<?=!empty($_POST["tags_condition"]) ? $_POST["tags_condition"] : "" ; ?>">
			</div>
			
			<div>
				<b>desc <input type="checkbox" name="desc_project" value="1"<?=(isset($_POST["desc_project"]) && $_POST["desc_project"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
			</div>
			
			<div class="img">
				<b>ava <input type="checkbox" name="ava_project" value="1"<?=(isset($_POST["ava_project"]) && $_POST["ava_project"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
			</div>
			
			<div class="img">
				<b>snap <input type="checkbox" name="snap_project" value="1"<?=(isset($_POST["snap_project"]) && $_POST["snap_project"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
			</div>
			
			<div class="img">
				<b>prevs <input type="checkbox" name="prevs_project" value="1"<?=(isset($_POST["prevs_project"]) && $_POST["prevs_project"] == "1") ? " checked" : "" ; ?>><font>(a)string</font></b>
			</div>
			
			<div>
				<b>starttime <input type="checkbox" name="starttime_project" value="1"<?=(isset($_POST["starttime_project"]) && $_POST["starttime_project"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
			</div>
			
			<div>
				<b>quality <input type="checkbox" name="quality_project" value="1"<?=(isset($_POST["quality_project"]) && $_POST["quality_project"] == "1") ? " checked" : "" ; ?>><font>(a)string</font></b>
			</div>
			
			<div>
				<b>mobile <input type="checkbox" name="mobile_project" value="1"<?=(isset($_POST["mobile_project"]) && $_POST["mobile_project"] == "1") ? " checked" : "" ; ?>><font>boolean</font></b>
				<a>==</a>
				<select name="mobile_condition">
					<option></option>
					<option value="false" <?=(!empty($_POST["mobile_condition"]) && $_POST["mobile_condition"] == "false") ? "selected" : "" ;?>>false</option>
					<option value="true" <?=(!empty($_POST["mobile_condition"]) && $_POST["mobile_condition"] == "true") ? "selected" : "" ;?>>true</option>
				</select>
			</div>
			
			<div>
				<b>toy <input type="checkbox" name="toy_project" value="1"<?=(isset($_POST["toy_project"]) && $_POST["toy_project"] == "1") ? " checked" : "" ; ?>><font>boolean</font></b>
				<a>==</a>
				<select name="toy_condition">
					<option></option>
					<option value="false" <?=(!empty($_POST["toy_condition"]) && $_POST["toy_condition"] == "false") ? "selected" : "" ;?>>false</option>
					<option value="true" <?=(!empty($_POST["toy_condition"]) && $_POST["toy_condition"] == "true") ? "selected" : "" ;?>>true</option>
				</select>
			</div>
			
			<div>
				<b>url <input type="checkbox" name="url_project" value="1"<?=(isset($_POST["url_project"]) && $_POST["url_project"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
			</div>
			
			<div>
				<b>ethnic <input type="checkbox" name="ethnic_project" value="1"<?=(isset($_POST["ethnic_project"]) && $_POST["ethnic_project"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>LIKE</a>
				<input type="text" name="ethnic_condition" value="<?=!empty($_POST["ethnic_condition"]) ? $_POST["ethnic_condition"] : "" ; ?>">
			</div>
			
			<div>
				<b>eyes <input type="checkbox" name="eyes_project" value="1"<?=(isset($_POST["eyes_project"]) && $_POST["eyes_project"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>LIKE,S</a>
				<input type="text" name="eyes_condition" value="<?=!empty($_POST["eyes_condition"]) ? $_POST["eyes_condition"] : "" ; ?>">
			</div>
			
			<div>
				<b>hair <input type="checkbox" name="hair_project" value="1"<?=(isset($_POST["hair_project"]) && $_POST["hair_project"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>LIKE</a>
				<input type="text" name="hair_condition" value="<?=!empty($_POST["hair_condition"]) ? $_POST["hair_condition"] : "" ; ?>">
			</div>
			
			<div>
				<b>height <input type="checkbox" name="height_project" value="1"<?=(isset($_POST["height_project"]) && $_POST["height_project"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>LIKE</a>
				<input type="text" name="height_condition" value="<?=!empty($_POST["height_condition"]) ? $_POST["height_condition"] : "" ; ?>">
			</div>
			
			<div>
				<b>body <input type="checkbox" name="body_project" value="1"<?=(isset($_POST["body_project"]) && $_POST["body_project"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>LIKE</a>
				<input type="text" name="body_condition" value="<?=!empty($_POST["body_condition"]) ? $_POST["body_condition"] : "" ; ?>">
			</div>
			
			<div>
				<b>a <input type="checkbox" name="a_project" value="1"<?=(isset($_POST["a_project"]) && $_POST["a_project"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
			</div>
			
			<div>
				<b>b <input type="checkbox" name="b_project" value="1"<?=(isset($_POST["b_project"]) && $_POST["b_project"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
			</div>
			
			<div>
				<b>ptype <input type="checkbox" name="ptype_project" value="1"<?=(isset($_POST["ptype_project"]) && $_POST["ptype_project"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
			</div>
			
			<div>
				<b>sizec <input type="checkbox" name="sizec_project" value="1"<?=(isset($_POST["sizec_project"]) && $_POST["sizec_project"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
			</div>
			
			<div>
				<b>cutted <input type="checkbox" name="cutted_project" value="1"<?=(isset($_POST["cutted_project"]) && $_POST["cutted_project"] == "1") ? " checked" : "" ; ?>><font>boolean</font></b>
			</div>
		
		</div>
		
		<input type="submit" value="go">
		
	</form>
	
</div>