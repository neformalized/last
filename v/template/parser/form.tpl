<div id="display" class="form">

	<form action="<?=$formAction?>" method="POST">
	
		<div class="main">
			<a>Название</a>
			<input type="text" name="name" value="<?=!empty($_POST["name"]) ? $_POST["name"] : "" ; ?>">
			<a>Сервис</a>
			<input type="text" name="service" value="<?=!empty($_POST["service"]) ? $_POST["service"] : "" ; ?>">
			<hr class="gr">
			<a>Активный</a>
			<select name="active">
				<option value="yes" <?=(!empty($_POST["active"]) && $_POST["active"] == "yes") ? "selected" : "" ;?>>да</option>
				<option value="no" <?=(!empty($_POST["active"]) && $_POST["active"] == "no") ? "selected" : "" ;?>>нет</option>
			</select>
			<a>Тип</a>
			<select name="type">
				<option value="usually" <?=(!empty($_POST["type"]) && $_POST["type"] == "usually") ? "selected" : "" ;?>>usually</option>
				<option value="trigger" <?=(!empty($_POST["type"]) && $_POST["type"] == "trigger") ? "selected" : "" ;?>>trigger</option>
			</select>
			<hr class="gr">
			<a>Method</a>
			<select name="method">
				<option value="GET" <?=(!empty($_POST["method"]) && $_POST["method"] == "GET") ? "selected" : "" ;?>>GET</option>
				<option value="POST" <?=(!empty($_POST["method"]) && $_POST["method"] == "POST") ? "selected" : "" ;?>>POST</option>
			</select>
			<a>Формат</a>
			<select name="encode">
				<option value="json" <?=(!empty($_POST["encode"]) && $_POST["encode"] == "json") ? "selected" : "" ;?>>json</option>
			</select>
			<hr class="gr">
			<a>Link</a>
			<input type="text" name="link" value="<?=!empty($_POST["link"]) ? $_POST["link"] : "" ; ?>">
			<a>Путь начала</a>
			<input type="text" name="start" value="<?=!empty($_POST["start"]) ? $_POST["start"] : "" ; ?>">
			<a>Путь к логину</a>
			<input type="text" name="login" value="<?=!empty($_POST["login"]) ? $_POST["login"] : "" ; ?>">
			<hr class="gr">
			<a>Image resample</a>
			<select name="imageresample">
				<option value="no" <?=(!empty($_POST["imageresample"]) && $_POST["imageresample"] == "no") ? "selected" : "" ;?>>нет</option>
				<option value="yes" <?=(!empty($_POST["imageresample"]) && $_POST["imageresample"] == "yes") ? "selected" : "" ;?>>да</option>
			</select>
			<a>Ширина</a>
			<input type="text" name="imagewidth" value="<?=!empty($_POST["imagewidth"]) ? $_POST["imagewidth"] : "" ; ?>">
			<a>Высота</a>
			<input type="text" name="imageheight" value="<?=!empty($_POST["imageheight"]) ? $_POST["imageheight"] : "" ; ?>">
			<div class="rgb">
				<div><a>R</a><input type="text" name="imager" value="<?=!empty($_POST["imager"]) ? $_POST["imager"] : "0" ; ?>"></div>
				<div><a>G</a><input type="text" name="imageg" value="<?=!empty($_POST["imageg"]) ? $_POST["imageg"] : "0" ; ?>"></div>
				<div><a>B</a><input type="text" name="imageb" value="<?=!empty($_POST["imageb"]) ? $_POST["imageb"] : "0" ; ?>"></div>
			</div>
		</div>
		
		<input type="submit" value="go">
		
		<div class="field">
			
			<div>
				<b>extid <input type="checkbox" name="extid_required" value="1"<?=(isset($_POST["extid_required"]) && $_POST["extid_required"] == "1") ? " checked" : "" ; ?>><font>int</font></b>
				<a>path</a>
				<input type="text" name="extid_path" value="<?=!empty($_POST["extid_path"]) ? $_POST["extid_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="extid_regexp" value="<?=!empty($_POST["extid_regexp"]) ? $_POST["extid_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>status <input type="checkbox" name="status_required" value="1"<?=(isset($_POST["status_required"]) && $_POST["status_required"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>path</a>
				<input type="text" name="status_path" value="<?=!empty($_POST["status_path"]) ? $_POST["status_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="status_regexp" value="<?=!empty($_POST["status_regexp"]) ? $_POST["status_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>username <input type="checkbox" name="username_required" value="1"<?=(isset($_POST["username_required"]) && $_POST["username_required"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>path</a>
				<input type="text" name="username_path" value="<?=!empty($_POST["username_path"]) ? $_POST["username_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="username_regexp" value="<?=!empty($_POST["username_regexp"]) ? $_POST["username_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>displayname <input type="checkbox" name="displayname_required" value="1"<?=(isset($_POST["displayname_required"]) && $_POST["displayname_required"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>path</a>
				<input type="text" name="displayname_path" value="<?=!empty($_POST["displayname_path"]) ? $_POST["displayname_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="displayname_regexp" value="<?=!empty($_POST["displayname_regexp"]) ? $_POST["displayname_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>platform <input type="checkbox" name="platform_required" value="1"<?=(isset($_POST["platform_required"]) && $_POST["platform_required"] == "1") ? " checked" : "" ; ?>><font>(a)string</font></b>
				<a>path</a>
				<input type="text" name="platform_path" value="<?=!empty($_POST["platform_path"]) ? $_POST["platform_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="platform_regexp" value="<?=!empty($_POST["platform_regexp"]) ? $_POST["platform_regexp"] : "" ; ?>">
			</div>
			
			<div class="rate">
				<b>rate* <input type="checkbox" name="rate_required" value="1"<?=(isset($_POST["rate_required"]) && $_POST["rate_required"] == "1") ? " checked" : "" ; ?>><font>int</font></b>
				<a>path</a>
				<input type="text" name="rate_path" value="<?=!empty($_POST["rate_path"]) ? $_POST["rate_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="rate_regexp" value="<?=!empty($_POST["rate_regexp"]) ? $_POST["rate_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>new <input type="checkbox" name="new_required" value="1"<?=(isset($_POST["new_required"]) && $_POST["new_required"] == "1") ? " checked" : "" ; ?>><font>boolean</font></b>
				<a>path</a>
				<input type="text" name="new_path" value="<?=!empty($_POST["new_path"]) ? $_POST["new_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="new_regexp" value="<?=!empty($_POST["new_regexp"]) ? $_POST["new_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>gender <input type="checkbox" name="gender_required" value="1"<?=(isset($_POST["gender_required"]) && $_POST["gender_required"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>path</a>
				<input type="text" name="gender_path" value="<?=!empty($_POST["gender_path"]) ? $_POST["gender_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="gender_regexp" value="<?=!empty($_POST["gender_regexp"]) ? $_POST["gender_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>birth <input type="checkbox" name="birth_required" value="1"<?=(isset($_POST["birth_required"]) && $_POST["birth_required"] == "1") ? " checked" : "" ; ?>><font>date</font></b>
				<a>path</a>
				<input type="text" name="birth_path" value="<?=!empty($_POST["birth_path"]) ? $_POST["birth_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="birth_regexp" value="<?=!empty($_POST["birth_regexp"]) ? $_POST["birth_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>age <input type="checkbox" name="age_required" value="1"<?=(isset($_POST["age_required"]) && $_POST["age_required"] == "1") ? " checked" : "" ; ?>><font>int</font></b>
				<a>path</a>
				<input type="text" name="age_path" value="<?=!empty($_POST["age_path"]) ? $_POST["age_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="age_regexp" value="<?=!empty($_POST["age_regexp"]) ? $_POST["age_regexp"] : "" ; ?>">
				<hr class="sm">
				<a>delimiter</a>
				<input type="text" name="age_delimiter" value="<?=!empty($_POST["age_delimiter"]) ? $_POST["age_delimiter"] : "" ; ?>">
			</div>
			
			<div>
				<b>lang <input type="checkbox" name="lang_required" value="1"<?=(isset($_POST["lang_required"]) && $_POST["lang_required"] == "1") ? " checked" : "" ; ?>><font>(a)string</font></b>
				<a>path</a>
				<input type="text" name="lang_path" value="<?=!empty($_POST["lang_path"]) ? $_POST["lang_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="lang_regexp" value="<?=!empty($_POST["lang_regexp"]) ? $_POST["lang_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>sublang <input type="checkbox" name="sublang_required" value="1"<?=(isset($_POST["sublang_required"]) && $_POST["sublang_required"] == "1") ? " checked" : "" ; ?>><font>(a)string</font></b>
				<a>path</a>
				<input type="text" name="sublang_path" value="<?=!empty($_POST["sublang_path"]) ? $_POST["sublang_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="sublang_regexp" value="<?=!empty($_POST["sublang_regexp"]) ? $_POST["sublang_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>country <input type="checkbox" name="country_required" value="1"<?=(isset($_POST["country_required"]) && $_POST["country_required"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>path</a>
				<input type="text" name="country_path" value="<?=!empty($_POST["country_path"]) ? $_POST["country_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="country_regexp" value="<?=!empty($_POST["country_regexp"]) ? $_POST["country_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>hiddenregions <input type="checkbox" name="hiddenregions_required" value="1"<?=(isset($_POST["hiddenregions_required"]) && $_POST["hiddenregions_required"] == "1") ? " checked" : "" ; ?>><font>(a)int</font></b>
				<a>path</a>
				<input type="text" name="hiddenregions_path" value="<?=!empty($_POST["hiddenregions_path"]) ? $_POST["hiddenregions_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="hiddenregions_regepx" value="<?=!empty($_POST["hiddenregions_regepx"]) ? $_POST["hiddenregions_regepx"] : "" ; ?>">
			</div>
			
			<div>
				<b>tags <input type="checkbox" name="tags_required" value="1"<?=(isset($_POST["tags_required"]) && $_POST["tags_required"] == "1") ? " checked" : "" ; ?>><font>(a)string</font></b>
				<a>path</a>
				<input type="text" name="tags_path" value="<?=!empty($_POST["tags_path"]) ? $_POST["tags_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="tags_regexp" value="<?=!empty($_POST["tags_regexp"]) ? $_POST["tags_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>desc <input type="checkbox" name="desc_required" value="1"<?=(isset($_POST["desc_required"]) && $_POST["desc_required"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>path</a>
				<input type="text" name="desc_path" value="<?=!empty($_POST["desc_path"]) ? $_POST["desc_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="desc_regexp" value="<?=!empty($_POST["desc_regexp"]) ? $_POST["desc_regexp"] : "" ; ?>">
			</div>
			
			<div class="img">
				<b>ava <input type="checkbox" name="ava_required" value="1"<?=(isset($_POST["ava_required"]) && $_POST["ava_required"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>path</a>
				<input type="text" name="ava_path" value="<?=!empty($_POST["ava_path"]) ? $_POST["ava_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="ava_regexp" value="<?=!empty($_POST["ava_regexp"]) ? $_POST["ava_regexp"] : "" ; ?>">
			</div>
			
			<div class="img">
				<b>snap <input type="checkbox" name="snap_required" value="1"<?=(isset($_POST["snap_required"]) && $_POST["snap_required"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>path</a>
				<input type="text" name="snap_path" value="<?=!empty($_POST["snap_path"]) ? $_POST["snap_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="snap_regexp" value="<?=!empty($_POST["snap_regexp"]) ? $_POST["snap_regexp"] : "" ; ?>">
				<hr class="sm">
				<a>href + path(%s)</a>
				<input type="text" name="snap_url" value="<?=!empty($_POST["snap_url"]) ? $_POST["snap_url"] : "" ; ?>">
			</div>
			
			<div class="img">
				<b>prevs* <input type="checkbox" name="prevs_required" value="1"<?=(isset($_POST["prevs_required"]) && $_POST["prevs_required"] == "1") ? " checked" : "" ; ?>><font>(a)string</font></b>
				<a>path</a>
				<input type="text" name="prevs_path" value="<?=!empty($_POST["prevs_path"]) ? $_POST["prevs_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="prevs_regexp" value="<?=!empty($_POST["prevs_regexp"]) ? $_POST["prevs_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>starttime <input type="checkbox" name="starttime_required" value="1"<?=(isset($_POST["starttime_required"]) && $_POST["starttime_required"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>path</a>
				<input type="text" name="starttime_path" value="<?=!empty($_POST["starttime_path"]) ? $_POST["starttime_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="starttime_regexp" value="<?=!empty($_POST["starttime_regexp"]) ? $_POST["starttime_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>quality <input type="checkbox" name="quality_required" value="1"<?=(isset($_POST["quality_required"]) && $_POST["quality_required"] == "1") ? " checked" : "" ; ?>><font>(a)string</font></b>
				<a>path</a>
				<input type="text" name="quality_path" value="<?=!empty($_POST["quality_path"]) ? $_POST["quality_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="quality_regexp" value="<?=!empty($_POST["quality_regexp"]) ? $_POST["quality_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>mobile <input type="checkbox" name="mobile_required" value="1"<?=(isset($_POST["mobile_required"]) && $_POST["mobile_required"] == "1") ? " checked" : "" ; ?>><font>boolean</font></b>
				<a>path</a>
				<input type="text" name="mobile_path" value="<?=!empty($_POST["mobile_path"]) ? $_POST["mobile_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="mobile_regexp" value="<?=!empty($_POST["mobile_regexp"]) ? $_POST["mobile_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>toy <input type="checkbox" name="toy_required" value="1"<?=(isset($_POST["toy_required"]) && $_POST["toy_required"] == "1") ? " checked" : "" ; ?>><font>boolean</font></b>
				<a>path</a>
				<input type="text" name="toy_path" value="<?=!empty($_POST["toy_path"]) ? $_POST["toy_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="toy_regexp" value="<?=!empty($_POST["toy_regexp"]) ? $_POST["toy_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>url <input type="checkbox" name="url_required" value="1"<?=(isset($_POST["url_required"]) && $_POST["url_required"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>path</a>
				<input type="text" name="url_path" value="<?=!empty($_POST["url_path"]) ? $_POST["url_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="url_regexp" value="<?=!empty($_POST["url_regexp"]) ? $_POST["url_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>ethnic <input type="checkbox" name="ethnic_required" value="1"<?=(isset($_POST["ethnic_required"]) && $_POST["ethnic_required"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>path</a>
				<input type="text" name="ethnic_path" value="<?=!empty($_POST["ethnic_path"]) ? $_POST["ethnic_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="ethnic_regexp" value="<?=!empty($_POST["ethnic_regexp"]) ? $_POST["ethnic_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>eyes <input type="checkbox" name="eyes_required" value="1"<?=(isset($_POST["eyes_required"]) && $_POST["eyes_required"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>path</a>
				<input type="text" name="eyes_path" value="<?=!empty($_POST["eyes_path"]) ? $_POST["eyes_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="eyes_regexp" value="<?=!empty($_POST["eyes_regexp"]) ? $_POST["eyes_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>hair <input type="checkbox" name="hair_required" value="1"<?=(isset($_POST["hair_required"]) && $_POST["hair_required"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>path</a>
				<input type="text" name="hair_path" value="<?=!empty($_POST["hair_path"]) ? $_POST["hair_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="hair_regexp" value="<?=!empty($_POST["hair_regexp"]) ? $_POST["hair_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>height <input type="checkbox" name="height_required" value="1"<?=(isset($_POST["height_required"]) && $_POST["height_required"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>path</a>
				<input type="text" name="height_path" value="<?=!empty($_POST["height_path"]) ? $_POST["height_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="height_regexp" value="<?=!empty($_POST["height_regexp"]) ? $_POST["height_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>body <input type="checkbox" name="body_required" value="1"<?=(isset($_POST["body_required"]) && $_POST["body_required"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>path</a>
				<input type="text" name="body_path" value="<?=!empty($_POST["body_path"]) ? $_POST["body_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="body_regexp" value="<?=!empty($_POST["body_regexp"]) ? $_POST["body_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>a <input type="checkbox" name="a_required" value="1"<?=(isset($_POST["a_required"]) && $_POST["a_required"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>path</a>
				<input type="text" name="a_path" value="<?=!empty($_POST["a_path"]) ? $_POST["a_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="a_regexp" value="<?=!empty($_POST["a_regexp"]) ? $_POST["a_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>b <input type="checkbox" name="b_required" value="1"<?=(isset($_POST["b_required"]) && $_POST["b_required"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>path</a>
				<input type="text" name="b_path" value="<?=!empty($_POST["b_path"]) ? $_POST["b_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="b_regexp" value="<?=!empty($_POST["b_regexp"]) ? $_POST["b_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>ptype <input type="checkbox" name="ptype_required" value="1"<?=(isset($_POST["ptype_required"]) && $_POST["ptype_required"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>path</a>
				<input type="text" name="ptype_path" value="<?=!empty($_POST["ptype_path"]) ? $_POST["ptype_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="ptype_regexp" value="<?=!empty($_POST["ptype_regexp"]) ? $_POST["ptype_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>sizec <input type="checkbox" name="sizec_required" value="1"<?=(isset($_POST["sizec_required"]) && $_POST["sizec_required"] == "1") ? " checked" : "" ; ?>><font>string</font></b>
				<a>path</a>
				<input type="text" name="sizec_path" value="<?=!empty($_POST["sizec_path"]) ? $_POST["sizec_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="sizec_regexp" value="<?=!empty($_POST["sizec_regexp"]) ? $_POST["sizec_regexp"] : "" ; ?>">
			</div>
			
			<div>
				<b>cutted <input type="checkbox" name="cutted_required" value="1"<?=(isset($_POST["cutted_required"]) && $_POST["cutted_required"] == "1") ? " checked" : "" ; ?>><font>boolean</font></b>
				<a>path</a>
				<input type="text" name="cutted_path" value="<?=!empty($_POST["cutted_path"]) ? $_POST["cutted_path"] : "" ; ?>">
				<a>regexp</a>
				<input type="text" name="cutted_regexp" value="<?=!empty($_POST["cutted_regexp"]) ? $_POST["cutted_regexp"] : "" ; ?>">
			</div>
			
		</div>
		
		<input type="submit" value="go">
		
	</form>
	
</div>