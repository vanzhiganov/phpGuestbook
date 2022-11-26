<?php
class ClCommon extends ClMysql {
	public function CheckValidEmail($email) {
		$pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$";

		if (eregi($pattern, $email)){ 
			return true; 
		} else { 
			return false; 
		}
	}
}

$Common =& new ClCommon();

class ClSettings extends ClMysql {
	public $Def;

	public function GetSettings() {
		$r = $this->Query("SELECT `value` FROM `perameters` WHERE `key`='settings'", DEBUG_MODE);
		$this->Def = json_decode($r);
	}

	public function Update($Array) {
		$this->Query("UPDATE  `perameters` SET `value` =  '".(json_encode($Array))."' WHERE  `key` = 'settings' LIMIT 1", DEBUG_MODE);
	}

}

$Settings =& new ClSettings();
$Settings->GetSettings();


