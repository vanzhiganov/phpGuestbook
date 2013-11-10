<?php
header("Content-type:image/jpeg");

include("../application/config.php");
include("../library/Mysql.php");
include("../library/Common.php");

$id = (isset($_GET['pid'])) ? (int) $_GET['pid']: "";
$full = (isset($_GET['full'])) ? (int) $_GET['full']: 0;

if ($id == "") {
	exit();
}

$query = $Mysql->Query("SELECT * FROM images WHERE image_id=$id", DEBUG_MODE);

//imagecreatefromjpeg( $row['name']);

if ($full == 0) {
	stripslashes ($query->content);
	echo $query->content;
} else {
	stripslashes ($query->full);
	echo $query->full;
}
