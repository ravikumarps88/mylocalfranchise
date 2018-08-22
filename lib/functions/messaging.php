<?

function displayMessages() {
	global $INFO_MSG, $ERR_MSG;
	
	$INFO_MSG = ($_SESSION['INFO_MSG']!="" ? $_SESSION['INFO_MSG'] : $INFO_MSG);
	
	if ($INFO_MSG!="") { 
	?>
    	toastr.success(<?=$INFO_MSG?>);
    <?	
	}
	
	$_SESSION['INFO_MSG'] = $INFO_MSG = "";

	$ERR_MSG = ($_SESSION['ERR_MSG']!="" ? $_SESSION['ERR_MSG'] : $ERR_MSG);
	if ($ERR_MSG!="") { 
	?>
    	toastr.error(<?=$INFO_MSG?>);
    <?
	}
	
	$_SESSION['ERR_MSG'] = $ERR_MSG = "";
}

?>