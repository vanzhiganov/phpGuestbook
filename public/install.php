<?php
include("../application/config.php");
include("../library/Mysql.php");
include("../library/Common.php");
include("../library/Images.php");
include("../library/Comments.php");


$Error = null;
$Errno = 0;
$InstallOk = false;

if ((isset($_POST['install'])) && $_POST['install'] == 'install') {
	$SubmitOk = true;


//	$Sql = file_get_contents ($_SERVER['DOCUMENT_ROOT']."/../mysql/mysql.sql");
	
	// DROP ALL
	$Mysql->Query("DROP TABLE IF EXISTS `comments`", true);
	$Mysql->Query("DROP TABLE IF EXISTS `images`", true);
	$Mysql->Query("DROP TABLE IF EXISTS `perameters`", true);
	$Mysql->Query("CREATE TABLE IF NOT EXISTS `comments` ( `comment_id` int(16) NOT NULL AUTO_INCREMENT,   `datetime` bigint(64) NOT NULL,   `approved` enum('y','n') NOT NULL DEFAULT 'y',   `user_id` int(64) NOT NULL DEFAULT '0',   `name` varchar(64) NOT NULL,   `email` varchar(64) NOT NULL,   `comment` longtext NOT NULL,   PRIMARY KEY (`comment_id`) ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36;", true);
	$Mysql->Query("CREATE TABLE IF NOT EXISTS `images` (`image_id` int(11) NOT NULL AUTO_INCREMENT,`comment_id` int(16) NOT NULL,`name` varchar(30) NOT NULL,`type` varchar(30) NOT NULL,`size` int(11) NOT NULL,`content` longblob NOT NULL,`full` blob NOT NULL,PRIMARY KEY (`image_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=143 ;", true);
	$Mysql->Query("CREATE TABLE IF NOT EXISTS `perameters` ( `key` varchar(32) NOT NULL,   `value` varchar(320) NOT NULL ) ENGINE=MyISAM DEFAULT CHARSET=utf8;", true);
	$Mysql->Query("INSERT INTO `perameters` (`key`, `value`) VALUES ('settings', '{\"ModerateComments\":\"n\",\"UploadImagesEnable\":\"y\",\"DateFormat\":\"Y-m-d h:i\",\"CommentsPerPage\":\"10\",\"UploadDir\":\"../tmp\"}');", true);

	if ($SubmitOk == true) {
		//header("Location: /");
		echo '<hr /><a href="/">На главную</a> | <a href="/settings">Настройки</a>';
		exit();
	}
}
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
		<div class="container !showgrid">
			<hr class="space" />
			<div class="span-6">
				<div style="text-align: center">
					<a href="/"><img src="/images/logo_softline.png" border="0" /></a>
					<hr class="space" />
					
					
				</div>
			</div>
			<div class="span-18 last" style="!background-color: #999">
				<h1>Установка</h1>
				<div class="" style="padding: 5px;">
					<?php
					if ($SubmitOk == false) {
						if ($Errno > 0) {
							foreach($Error as $er) {
								echo "<div class='error'>".$er."</div>";
							}
						}
					}
					?>
					<p>Для успешного завершения установки твоей гостевой книги, ты должен был прочитать инструкцию, которая расположена <b>/documentation/install.odt</b>.</p>
					<p>После нажатия кнопки "<b>Установить</b>" что расположена чуть ниже, будет установлена база данных.</p>
					<p>После, в БД будут установленны некоторые изначальные параметры, изменить которые ты можешь по адресу http://yousite<b>/settings</b>.</p>
					<div class="notice">Внимание! Все данные в указанной БД будут уничтожены.</div>
					<form id="form1" name="form1" method="post" action="/install.php">
					<input type="hidden" name="install" value="install"  />
					<div style="font-size:20px">
						<hr class="space" />
						<input type="submit" value="Установить"  style="font-size:20px" />
					</div>
					</form>
				</div>
				<hr class="space" />
			</div>

			<hr class="space" />
		
    </div>
  </body>
</html>
