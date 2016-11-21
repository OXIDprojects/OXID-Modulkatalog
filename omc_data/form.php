<html>
<head>
	<title>Modulformular</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>

<style>	
.wmfg_layout_1, table, .wmfg_textarea { font-family: Verdana, Geneva, sans-serif; font-size: 13px; }
.wmfg_layout_1 ul.wmfg_questions { list-style-type: none; margin: 0; padding: 0; }
.wmfg_layout_1 ul.wmfg_questions li.wmfg_q { margin: 10px 0; }
.wmfg_layout_1 label.wmfg_label { display: block; margin: 0 0 5px 0; font-weight:bold; }
.wmfg_layout_1 table.wmfg_answers { width: 100%; _width: 97%; border-collapse: collapse; }
.wmfg_layout_1 table.wmfg_answers { vertical-align: top; }
.wmfg_layout_1 table.wmfg_answers td { padding: 2px; vertical-align: top; }
.wmfg_layout_1 table.wmfg_answers td.wmfg_a_td { width: 25px; }

.wmfg_layout_1 .wmfg_text { border: 1px solid #CCC; padding: 4px; font-size: 13px; color: #000000; width: 98.5%;
background-color: #ffffff;
background:-webkit-gradient(linear,0 0,0 100%,from(#f8f8f8),to(#fff));
background:-moz-linear-gradient(top,#f8f8f8,#fff);
}
.wmfg_layout_1 .wmfg_textarea { border: 1px solid #CCC; padding: 4px; font-size: 13px; color: #000000; width: 98.5%;
background:-webkit-gradient(linear,0 0,0 100%,from(#f8f8f8),to(#fff));
background:-moz-linear-gradient(top,#f8f8f8,#fff);
background-color: #ffffff;
}
.wmfg_layout_1 .wmfg_select { 
border:1px solid #CCCCCC; padding: 3px; font-size: 13px; color: #000000; margin: 0; width: 100%; _width: 97%;
background-color: #ffffff;
background:-webkit-gradient(linear,0 0,0 100%,from(#f8f8f8),to(#fff));
background:-moz-linear-gradient(top,#f8f8f8,#fff);
}
.wmfg_layout_1 .wmfg_btn { 
border: 1px solid #cccccc; cursor: pointer; font-weight: normal; font-size: 13px; padding: 6px; color: #444; font-family: 'lucida grande', tahoma, verdana, arial, sans-serif; 
background: -webkit-gradient(linear, left top, left bottom, from(#FAFAFA), color-stop(0.5, #FAFAFA), color-stop(0.5, #E5E5E5), to(#F9F9F9)); 
background: -moz-linear-gradient(top, #FAFAFA, #FAFAFA 50%, #E5E5E5 50%, #F9F9F9);
filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='#FAFAFA', endColorstr='#E5E5E5');
}
.wmfg_layout_1 .wmfg_btn:hover {  
background: -webkit-gradient(linear, left top, left bottom, from(#EDEDED), color-stop(0.5, #EDEDED), color-stop(0.5, #D9D9D9), to(#EDEDED)); 
background: -moz-linear-gradient(top, #EDEDED, #EDEDED 50%, #D9D9D9 50%, #EDEDED);
filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='#E3326E', endColorstr='#D9D9D9'); 
</style>

<div style="width:600px" class="wmfg_layout_1">

<form method="post" action="http://oxid-dev.com:8081/form.php">
<input type="hidden" name="formsend" value="true">

<ul class="wmfg_questions">

<?php
if($_POST["formsend"]) {

	if(!empty($_POST["modul_name"]) && !empty($_POST["modul_url"]) && !empty($_POST["modul_price"])) {

		$data = array();
		foreach($_POST as $key => $value) {
			$data[$key] = strip_tags(trim($value));
		}

		$db = new mysqli("mysql_host", "omc", "somepass", "omc");
		
		$sql = 'INSERT IGNORE INTO modules (title, url_info, price, vendor, created_at, updated_at) VALUES ("'.$data["modul_name"].'", "'.$data["modul_url"].'", "'.$data["modul_price"].'", 34, "'.date("Y-m-d H:i:s").'", "'.date("Y-m-d H:i:s").'")';
		$statement = mysqli_query($db, $sql);
		
		if($statement) {
	?>
		<li class="wmfg_q" style="text-align: center;">
			<br><span style="color: green; font-weight: bold;">Modul wurde erfolgreich eingetragen!</span><br><br>
		</li>
	<?php	
		} else {
	?>
		<li class="wmfg_q" style="text-align: center;">
			<br><span style="color: red; font-weight: bold;">Fehler beim Eintragen des Moduls, bitte Formular neu laden!</span><br><br>
		</li>
	<?php
		}
	} else {
	?>
		<li class="wmfg_q" style="text-align: center;">
			<br><span style="color: red; font-weight: bold;">Bitte Pflichtfelder ausfüllen!</span><br><br>
		</li>
	<?php
	}

}
?>

	<li class="wmfg_q">
		<label class="wmfg_label" for="text_id">Modulname *</label>
		<input type="text" class="wmfg_text" name="modul_name" id="text_id" value="" />
	</li>
	<li class="wmfg_q">
		<label class="wmfg_label" for="text_id">URL Modulinformationen (http ...) *</label>
		<input type="text" class="wmfg_text" name="modul_url" id="text_id" value="" />
	</li>
	<li class="wmfg_q">
		<label class="wmfg_label" for="text_id">Preis (Brutto, Format: 0.00) *</label>
		<input type="text" class="wmfg_text" name="modul_price" id="text_id" value="" />
	</li>
	<li class="wmfg_q" style="text-align: center;">
		<br>
		<div class="g-recaptcha" data-sitekey="6LfhhAwUAAAAALRl6Hci4y4K1Qb1TbSots0hvhOU"></div>
		<br>
	</li>
	<li class="wmfg_q">
		<input type="submit" name="submit" class="wmfg_text" value=" Modul eintragen " />
		<p>&nbsp;</p>
		<small>* Pflichtfelder</small>
	</li>

</ul>

</form>

</div>

</body>

</html>