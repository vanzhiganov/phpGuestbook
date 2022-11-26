<?php
include("application/config.php");
include("library/Mysql.php");
include("library/Common.php");
include("library/Images.php");
include("library/Comments.php");

$Post->NewComment->Submit = (isset($_POST['submit'])) ? (int) $_POST['submit'] : 0;

$Error = null;
$Errno = 0;
$SubmitOk = false;

if ($Post->NewComment->Submit == 1) {
	$SubmitOk = true;
	
	$Post->NewComment->Name = (isset($_POST['name'])) ? stripcslashes(strip_tags($_POST['name'])) : null;
	$Post->NewComment->Email = (isset($_POST['email'])) ? stripcslashes(strip_tags($_POST['email'])) : null;
	$Post->NewComment->Comment = (isset($_POST['comment'])) ? stripcslashes(strip_tags($_POST['comment'])) : null;

	if ($Common->CheckValidEmail($Post->NewComment->Email) == false || $Post->NewComment->Email == null) {
		$SubmitOk = false;
		$Error[$Errno++] = "Некорректный адрес е-почты";
	}

	if ($Post->NewComment->Name == "" || $Post->NewComment->Name == null) {
		$SubmitOk = false;
		$Error[$Errno++] = "Имя не указано";
	}
	if ($Post->NewComment->Comment == "" || $Post->NewComment->Comment == null) {
		$SubmitOk = false;
		$Error[$Errno++] = "Комментарий отсутствует";
	}

	//---
	
	if ($SubmitOk == true) {
		$NewcommentID = $Comments->NewItem(array('name'=>$Post->NewComment->Name,'email'=>$Post->NewComment->Email,'comment'=>$Post->NewComment->Comment));

		if (isset($_POST['upload']) && $_FILES['userfile']['size'] > 0 && $Settings->Def->UploadImagesEnable == 'y') {
			$type=$_FILES['userfile']['type'];
			$size=$_FILES['userfile']['size'];
			$error=$_FILES['userfile']['error'];
			$name=$_FILES['userfile']['tmp_name'];
			$realname=$_FILES['userfile']['name'];
			$newname=$Settings->Def->UploadDir."/".$realname;

			copy($_FILES['userfile']['tmp_name'], $newname);

			$status=$Images->checkfile($size,$error, $newname);
			
			if ($status == true) {
				
				//echo "Image Gogo";
				$Images->fileoperation($newname);
				/*** GETTING THE IMAGE REDUCED SIZE FROM CLASS SECUREIMAGE***/
				$sizereduced=$Images->redsize;

				$query = "INSERT INTO images (comment_id,name, type, size, content, full) VALUES ('{$NewcommentID}', '$realname', '$type',  '$sizereduced', '{$Images->thumb}', '{$Images->image}')";
				$result = $Mysql->Query($query, false); 
			}
		}

		header("Location: /");
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
		<link rel="stylesheet" href="css/blueprint/screen.css" type="text/css" media="screen, projection">
		<link rel="stylesheet" href="css/blueprint/print.css" type="text/css" media="print">
		<!--[if lt IE 8]><link rel="stylesheet" href="css/blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->
		<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen">
	</head>
	<body>
		<hr class="space" />
		<div class="container !showgrid">
			<hr class="space" />
			<div class="span-6">
				<div style="text-align: center">
					<a href="/"><img src="images/logo_softline.png" border="0" /></a>
					<hr class="space" />
					<div style="background-color: #DB6C0F; padding: 15px;margin: 15px; cursor: pointer;" onclick="location.href='/new'">
						<a href="new" style="color: #000; text-decoration: none; font-size: 20px; text-shadow: 1px 1px #F0E3C0">Новая запись</a>
					</div>
				</div>
			</div>
			<div class="span-18 last" style="!background-color: #999">
				<h1>Новое сообщение</h1>
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
					<form id="form1" name="form1" method="post" action="./new"  enctype="multipart/form-data">
					<input type="hidden" name="submit" id="submit" value="1" />
					<div style="font-size:20px">
						Имя<br />
						<input name="name" type="text" id="name" value="" size="40" style="font-size:20px" />
					</div>
					<div style="font-size:20px">
						Email<br />
						<input name="email" type="text" id="email" value="" size="40" style="font-size:20px" />
					</div>
					<div style="font-size:20px">
						Сообщение<br />
						<textarea name="comment" cols="40" rows="3" id="comment"></textarea>
					</div>
					<?php if ($Settings->Def->UploadImagesEnable == 'y' ) { ?>
					<div style="font-size:20px">
						Загрузить изображение<br />
						<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
						<input name="userfile" type="file" id="userfile">
						<input name="upload" type="hidden" id="upload" value="1">
						
					</div>
					<?php } ?>
					<div style="font-size:20px">
						<hr class="space" />
						<input type="submit" value="Сохранить"  style="font-size:20px" />
					</div>
					</form>
				</div>
				<hr class="space" />
                </div>
            <hr class="space" />
        </div>
    </body>
</html>
