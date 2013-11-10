<?php
class ClComments extends ClMysql {
	public $CountAll = 0;

	public function NewItem($Arr) {
		$currenttime = time(); //date time

		$this->Query("INSERT INTO `comments` (`datetime`, name, email, comment) VALUES ('{$currenttime}', '{$Arr['name']}', '{$Arr['email']}', '{$Arr['comment']}')", DEBUG_MODE);
		return $this->insert_id;
	}
	
	public function GetItems($ArrColumns, $Approved = 'y', $OrderBy = 'ASC', $ArrLimits = null) {
		$sels = implode(",",$ArrColumns);
		$r = $this->Query("SELECT {$sels} FROM `comments` WHERE `approved`='{$Approved}' ORDER BY `datetime` {$OrderBy} ".(($ArrLimits == null)? null : "LIMIT ".implode(",",$ArrLimits)), DEBUG_MODE);
		$this->num_rows;
		if ($this->num_rows == 0) {
			return 0;
		} else {
			if ($this->num_rows == 1) {
				$res[0] = $r;
			} else {
				$res = $r;
			}
			return $res;
		}
	}
	
	public function CountAll() {
		$this->CountAll = $this->Query("SELECT COUNT(*) FROM  `comments`", DEBUG_MODE);
		return 0;
	}
}

$Comments =& new ClComments();
