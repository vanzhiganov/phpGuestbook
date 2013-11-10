<?php
include("../application/config.php");
include("../library/Mysql.php");
include("../library/Common.php");
include("../library/Comments.php");

$Comments->CountAll();

// ----
$n_page = ( isset( $_GET['p'] ) ) ? (int) $_GET['p'] : 0;
$from = $n_page * $Settings->Def->CommentsPerPage;

$Content = null;



if ($Comments->CountAll == 0) {
	$Content .= '<div class="" style="padding-right: 10px;">';
	$Content .= '<div class="info">';
	$Content .= 'Нет ни одного сообщения.';
	$Content .= 'Стань первым! Напиши в книгу...';
	$Content .= '</div>';
	$Content .= '</div>';
} else {
	$ListComments = $Comments->GetItems(array('comment_id','datetime','name','comment'), 'y', 'DESC', array($from,$Settings->Def->CommentsPerPage));

	foreach($ListComments as $lc) {
		$img = null;
		$query = $Mysql->Query("select * FROM images where `comment_id`='{$lc->comment_id}' LIMIT 0,1");
		if ($Mysql->num_rows == 1) {

			$img = '<div style="border:5px solid; border-color:#3b6670; float:left;;">
<a href="/image.php?pid='.$query->image_id.'&full=1"><img src="/image.php?pid='.$query->image_id.'"/></a>
</div><hr class="space" />';
//echo '/image.php?pid='.$query['image_id;
  }
		
		
		$Content .= '<div class="" style="padding: 5px;">';
		$Content .= '<div style="color: #999; font-size: 25px">#'.$lc->comment_id.' - <b>'.$lc->name.'</b> ('.(date($Settings->Def->DateFormat, $lc->datetime)).')</div>';
		$Content .= '<div style="font-size: 20px;">';
		$Content .= '<p>'.str_replace("\n", "<br>", $lc->comment).'</p>';
		$Content .= '</div>';
		$Content .= '<div class="">'.$img.'</div>';
		$Content .= '</div>';
	}

	$Pagination = null;
	$cnt = ceil( $Comments->CountAll / $Settings->Def->CommentsPerPage);

	for ( $i = 0; $i < $cnt; $i++ ) {
		if ($n_page == $i) {
			$Pagination .= " <a href='?p=$i' ><img src='/images/nav_current.png' border='0' /></a> ";
		} else {
			$Pagination .= " <a href='?p=$i' ><img src='/images/nav_other.png' border='0' /></a> ";
		}
	}

	$Content .= '<div class="navigationpages">';
	$Content .= '<p>'.$Pagination.'</p>';
	$Content .= '</div>';
}
//---
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
				<?php echo $Content; ?>
			</div>
			<hr class="space" />
		</div>
	</body>
</html>
