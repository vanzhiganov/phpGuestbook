<?php
include("../application/config.php");
include("../library/Mysql.php");
include("../library/Common.php");
include("../library/Comments.php");

//---
$Saved = false;
if (isset($_POST['submit']) && $_POST['submit'] == 1) {
	unset($_POST['submit']);
	
	if (!isset($_POST['ModerateComments'])) {
		$_POST['ModerateComments'] = 'n';
	}

	if (!isset($_POST['UploadImagesEnable'])) {
		$_POST['UploadImagesEnable'] = 'n';
	}

	if (!isset($_POST['UploadDir'])) {
		$_POST['UploadDir'] = '../tmp';
	}

	if (!isset($_POST['CommentsPerPage'])) {
		$_POST['CommentsPerPage'] = 10;
	}

	$Settings->Update($_POST);
	$Saved = true;
	$Settings->GetSettings();
}
	//exit();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="ru">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Гостевая книга</title>
		<!-- Framework CSS -->
		<link rel="stylesheet" href="/css/blueprint/screen.css" type="text/css" media="screen, projection">
		<link rel="stylesheet" href="/css/blueprint/print.css" type="text/css" media="print">
		<!--[if lt IE 8]><link rel="stylesheet" href="/css/blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->
		<link rel="stylesheet" href="/css/screen.css" type="text/css" media="screen">
	</head>
	<body>
		<hr class="space" />
		<div class="container">
			<hr class="space" />
			<div class="span-6">
				<div style="text-align: center">
					<a href="/"><img src="/images/logo_softline.png" border="0" /></a>
					<hr class="space" />
					<div id="buttom_newmessage" onclick="location.href='/new'">
						<a href="/new">Новая запись</a>
					</div>
				</div>
			</div>
			<div class="span-18 last">
				<h1>Гостевая книга</h1>
				
				
				
				<div class="" style="padding: 5px;">
				<?php if ($Saved == true) { echo "<div class='success'>Изменения сохранены.</div>"; } ?>
					<form id="form1" name="form1" method="post" action="/settings">
					<input type="hidden" name="submit" id="submit" value="1" />
					<input type="hidden" name="ModerateComments" id="ModerateComments" value="n">
					<!-- div style="font-size:20px">
						Модерировать сообщения перед публикацией?<br />
						<select name="ModerateComments" id="ModerateComments" style="font-size:20px">
						<option value="n">Нет</option>
						<option value="y">Да</option>
						</select>
					</div-->
					
					<div style="font-size:20px">
						Раздешить загрузку изображений?<br />
						<select name="UploadImagesEnable" id="UploadImagesEnable" style="font-size:20px">
						<option value="n" <?=(($Settings->Def->UploadImagesEnable=='n')? 'selected': '');?>>Нет</option>
						<option value="y" <?=(($Settings->Def->UploadImagesEnable=='y')? 'selected': '');?>>Да</option>
						</select>
					</div>

					<div style="font-size:20px">
						Директория для загрузки изображений<br />
						<?=$_SERVER['DOCUMENT_ROOT'];?>/<input type="text"  name="DateFormat" id="DateFormat" value="<?=((isset($Settings->Def->UploadDir)) ? $Settings->Def->UploadDir : "../tmp");?>" size="20" style="font-size:20px" />
					</div>

						<?php
						if ($Settings->Def->CommentsPerPage == 10) { $check10 = "selected='selected'"; } else { $check10 = null;}
						if ($Settings->Def->CommentsPerPage == 20) { $check20 = "selected='selected'"; } else { $check0 = null;}
						if ($Settings->Def->CommentsPerPage == 40) { $check40 = "selected='selected'"; } else { $check10 = null;}
						?>
						<div style="font-size:20px">
						Кол-во сообщений на странице<br />
						<select name="CommentsPerPage" id="CommentsPerPage"  style="font-size:20px">
							<option value="10" <?=$check10;?>>10</option>
							<option value="20" <?=$check20;?>>20</option>
							<option value="40" <?=$check40;?>>40</option>
						</select>
					</div>
					<div style="font-size:20px">
						Формат даты<br />
						<input type="text"  name="DateFormat" id="DateFormat" value="<?=$Settings->Def->DateFormat;?>" size="40" style="font-size:20px" />
					</div>
					<div style="font-size:20px">
						<input type="submit" value="Сохранить"  style="font-size:20px" />
					</div>
					</form>
				</div>
		
			</div>
			<hr class="space" />
		</div>
	</body>
</html>
