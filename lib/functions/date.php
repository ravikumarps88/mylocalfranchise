<?

// mm-dd-yyyy to yyyy-mm-dd
function toMysqlDate($str) {
	if ($str=="") {
		return "0000-00-00";
	}
	
	$temp = split("-", $str);
	if (count($temp)!=3) {
		return "0000-00-00";
	}
	
	return $temp[2]."-".$temp[0]."-".$temp[1];	
}

// yyyy-mm-dd to mm-dd-yyyy
function toNormalDate($str) {
	if ($str=="") {
		return "";
	}
	
	$temp = split("-", $str);
	if (count($temp)!=3) {
		return "";
	}
	
	return $temp[1]."-".$temp[2]."-".$temp[0];	

}

?>