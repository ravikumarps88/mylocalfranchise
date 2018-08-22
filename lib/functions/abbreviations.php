<?

// function aliases, for easy coding!!!

function he($p1) {
	return htmlentities($p1);
}

/*function mre($p1) {
	//return mysql_real_escape_string($p1);
}*/

function ue($p1) {
	return urlencode($p1);
}

function ud($p1) {
	return urldecode($p1);
}

function nf($p1, $p2) {
	$p1 = sprintf("%.2f", $p1);
	return number_format($p1, $p2);
}

?>