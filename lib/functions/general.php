<?
// convert date to mysql compatable
function convertToMysqlDate($date, $separator)	{
	$edate	= explode($separator, $date);
	return	$edate[2]."-".$edate[1]."-".$edate[0];
}

// convert mysql date to text box compatible
function convertMysqlToDate($date, $separator)	{
	$edate	= explode($separator, $date);
	return	$edate[2]."/".$edate[1]."/".$edate[0];
}
//strip all slashes
function no_magic_quotes($query) {
        $data = explode("\\",$query);
        $cleaned = implode("",$data);
        return $cleaned;
}

function limitedString($str, $length, $suffix="...") {
	if (strlen($str)<=$length) return $str;
	
	return (substr($str, 0, $length-strlen($suffix)). $suffix);
}

// fixes magic quotes
function fixMagicQuotes() {
	if (get_magic_quotes_gpc()) {
		foreach ($_GET as $k=>$v) {
			$_GET[$k] = stripslashes($v);
		}
		foreach ($_POST as $k=>$v) {
			$_POST[$k] = stripslashes($v);
		}
	}
}

// loads config values from the table 'config'
function loadConfig() {
	$query = "select cfgkey, cfgval from config";
	$configArray = dbQuery($query);
	for ($i=0; $i<count($configArray); $i++) {
		define($configArray[$i]['cfgkey'], $configArray[$i]['cfgval']);
	}
}

/**
* Cleans the filename
* It sets all characters in lowercase, drops spaces and special characters
* Allowed chars are a-z, 0-9, _ and -
* Drops all dots in the data, except the one before extension
* @param data the data to be formated
* @return the formated data
*/
function cleanFilename($data)
{
    $formatted_data = "";
    for ($i=0; $i<strlen($data); $i++)
    {
        $char_code = ord($data[$i]);
        if ($char_code>=65 && $char_code<=90) // A-Z => a-z
        {
            $formatted_data .= strtolower($data[$i]);
        } elseif ($char_code>=97 && $char_code<=122) { // a-z
            $formatted_data .= $data[$i];
        } elseif ($char_code>=48 && $char_code<=57) {   // 0-9
            $formatted_data .= $data[$i];
        } elseif ($data[$i]=="-" || $data[$i]=="_" || $data[$i]==".") {   // -,_
            $formatted_data .= $data[$i];
        }
    }
    
    // erase all dots in the filename, except the one before extension
    $temp_array = explode(".", $formatted_data);
    if (count($temp_array) > 2) {
		$data_without_extn = "";
		for ($i=0; $i<count($temp_array); $i++)
		{
			$data_without_extn .= $temp_array[$i];
			if ($i==count($temp_array)-2)
			{
				$data_without_extn .= ".";
			}
		}
	// Fixed the bug 'empty return on proper filename'
	} else {		
		$data_without_extn = $formatted_data;
	}
	// End: Fixed the bug 'empty return on proper filename'
    
    return $data_without_extn;
}


// creates html options (for select element)
// the array should contain the keys 'optionId' and 'optionText'
function htmlOptions($keyValArray, $selectedId="") {
	$htmlOptionStr = "";
	for ($i=0; $i<count($keyValArray); $i++) {
		$selectedStr = (trim($keyValArray[$i]['optionId'])==trim($selectedId) ? "selected" : "");
		$htmlOptionStr .= "<option value='".he(trim($keyValArray[$i]['optionId']))."' $selectedStr >".no_magic_quotes(he($keyValArray[$i]['optionText']))."</option>\n";
	}
	return $htmlOptionStr;
}


/**
* Checks if the extension of the file is valid or not
* @param filename the name of the file
* @param extensions_string extensions allowed separated by '|' symbol
*   eg: jpg|gif
* @return true or false
*/
function isValidExtension($filename, $extensions_string) {
    $extensions_string = trim($extensions_string);
    if ($extensions_string=="") {
        return false;
    }
    $extension_list = explode("|", $extensions_string);
    if (count($extension_list)==0) {
        return false;        
    }
    
    $extension = strtolower(substr($filename, strrpos($filename, ".")+1));
    return (in_array($extension, $extension_list) ? true : false);
}


// returns the extension
function getExtension($filename) {
	$extension = strtolower(substr($filename, strrpos($filename, ".")+1));
	return $extension;
}


function randomString($length) {
	$str = "";
	for ($i=0; $i<$length; $i++) {
		$str .= chr(rand(65, 90));
	}
	return $str;
}

function generateCode()	{
	return substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789',7)),0,7);
}

function ResizeImage($img, $maxwidth, $maxheight, $filename) {
	$imgTrans = new imageTransform();
	$imgTrans->sourceFile = $img;
	$imgTrans->targetFile = $filename;
	$imgTrans->resizeToWidth = $maxwidth;
	$imgTrans->resizeToHeight = $maxheight;
	$imgTrans->resizeIfSmaller = false;
	$imgTrans->jpegOutputQuality = 90;
	return $imgTrans->resize();
}


function remove_accent($str) 
{ 
  $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', 'IJ', 'ij', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', 'Œ', 'œ', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', 'Š', 'š', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', 'Ÿ', '?', '?', '?', '?', 'Ž', 'ž', '?', 'ƒ', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?'); 
  $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o'); 
  return str_replace($a, $b, $str); 
} 

function post_slug($str) 
{ 
  return strtolower(preg_replace(array('/[^a-zA-Z0-9 _-]/', '/[ -]+/', '/^-|-$/'), 
  array('', '-', ''), remove_accent($str))); 
}

function remove_sp_characters($str)	{
  return preg_replace('/[^(\x20-\x7F)\x0A]*/','', $str);
}



// Email sending ot function
function mailbox($opt,$params,$flag='')	{
global $siteemail,$sitename,$siteurl;
$to		= $params[0];
$name	= $params[1];
$from	= $params[2];
$subject= $params[3];
$body	= $params[4];

$bcc	= $params[5];

$content	= '<body style="margin: 0px;">
	<div marginwidth="0" marginheight="0" style="width:100%!important;margin:0;padding:0;display:block;margin-top:0;margin-bottom:0;background-color:#e9eaed;font-family:Open Sans,Helvetica,Arial,sans-serif;font-size:13px">
			<span style="margin:0;padding:0;display:block;margin-top:0;margin-bottom:0"> 
				<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin:0;padding:0;width:100%!important;background-color:#f9f9f9;font-family:Helvetica,Arial,sans-serif;font-size:13px">
	<tbody>
	<tr style="padding:0">
	<td align="center" valign="top" width="100%" style="color:#333;font-family:Helvetica,Arial,sans-serif;font-size:13px;padding:0;border-collapse:collapse;background-color:#2389CE">
						<table border="0" width="550" cellpadding="0" cellspacing="0" style="background-color:#2389CE"><tbody><tr style="padding:0">
	<td align="center" valign="top" style="color:#333;font-family:Helvetica,Arial,sans-serif;font-size:13px;padding:0;border-collapse:collapse"><h1 style="color:#fff;text-align:center;font-size:2em;padding:0;margin:0;line-height:0"><a href="#" style="color:#fff;text-decoration:none;line-height:0;display:block" target="_blank">
						  <img src="'.APP_URL.'/images/Email-HeaderrV.1.jpg" alt="Saverplaces.co.uk" width="100%" style="border:0;line-height:100%;outline:none;text-decoration:none;display:inline-block;max-width:550px;max-height:90px"></a></h1></td>
						</tr></tbody></table>
	</td>
				</tr>
	<tr style="padding:0">
	<td align="center" valign="top" style="color:#333;font-family:Helvetica,Arial,sans-serif;font-size:13px;padding:0;border-collapse:collapse">
	
												
														<table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr style="padding:0">
	<td width="100%" height="20" style="color:#333;font-family:Helvetica,Arial,sans-serif;font-size:13px;padding:0;border-collapse:collapse"> </td>
									</tr></tbody></table>
	<table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr style="padding:0">
	<td width="100%" style="color:#333;font-family:Helvetica,Arial,sans-serif;font-size:13px;padding:0;border-collapse:collapse">
								<table border="0" cellpadding="0" cellspacing="0" width="550" align="center">
	<tbody><tr style="padding:0">
	<td style="color:#333;font-family:Helvetica,Arial,sans-serif;font-size:13px;padding:0;border-collapse:collapse;padding-bottom:20px;text-align:left">
	
					
					
	
			
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody><tr style="padding:0">
	<td style="color:#333;font-family:Helvetica,Arial,sans-serif;font-size:15px; line-height:22px; color:#616161;padding:15px;border-collapse:collapse;background-color:#fff;border-top: 1px solid #dcdcdc;border-bottom: 2px solid #dcdcdc;
	border-left: 1px solid #dcdcdc;
	border-right: 1px solid #dcdcdc;text-align:left">
		'.$body.'
	  </td>
			</tr>
			
	<tr> <td style="padding: 5px;"></td></tr>
			
	<tr> <td style="padding: 5px;"></td></tr>
			
	<tr style="padding:0">
	  <td align="center" style="color:#333;font-family:Helvetica,Arial,sans-serif;font-size:14px;padding:10px 0;border-collapse:collapse;background-color: white;border-top: 1px solid #dcdcdc;border-bottom: 1px solid #dcdcdc;
	border-left: 1px solid #dcdcdc;
	border-right: 1px solid #dcdcdc;text-align:center!important;width:100%"><a href="http://www.saverplaces.co.uk" style="color:#07c;text-decoration:none" target="_blank">Find Some Great Local Offers<span></span></a></td>
	</tr>
	
	</tbody></table>
	
	</td>
	</tr>
	</tbody></table>
	</td>
						</tr></tbody></table>
	
	</td>
				</tr>
	<tr style="padding:0">
	<td align="center" valign="top" style="color:#333;font-family:Helvetica,Arial,sans-serif;font-size:13px;padding:0;border-collapse:collapse">
						<table border="0" cellpadding="0" cellspacing="0" width="550">
	<tbody>
	<tr style="padding:0">
	<td align="center" valign="top" style="color:#333;font-family:Helvetica,Arial,sans-serif;font-size:13px;padding:0;border-collapse:collapse;max-width:570px">
	
	
	
	
								<table border="0" cellpadding="0" cellspacing="0">
	  <tbody><tr style="padding:0"><td height="20" style="color:#333;font-family:Helvetica,Arial,sans-serif;font-size:13px;padding:0;border-collapse:collapse;max-width:570px"> </td></tr>
	<tr style="padding:0">
	<td align="center" valign="top" style="color:#333;font-family:Helvetica,Arial,sans-serif;font-size:13px;padding:0;border-collapse:collapse;max-width:570px;padding-bottom:40px;width:242px"><p style="line-height:23px;font-weight:400;padding:0;margin:0;color:#9c9c9c;padding-left:10px;padding-right:10px"><img width="249" height="30" alt="the place for local vouchers" src="'.APP_URL.'/images/the-place-for-local-vouchers.png" style="border:0;line-height:100%;outline:none;text-decoration:none;display:block"></p></td>
						  </tr>
	</tbody></table>
	</td>
				  </tr>
	</tbody></table>
	</td>
				</tr>
	
	</tbody></table></span>
			
	</div>

</body>';


//echo "To: ".$to."<br>Name: ".$name."<br>Frommail: ".$from."<br>Subject: ".$subject."<br>Matter: ".$matter;
	firemail($to,$name,$from,$subject,$body,$bcc);
}

function firemail($to,$name,$from,$subj,$body,$bcc='')	{
	global $SERVER_NAME;
	
	$recipient = $to;
	$headers  = "From: " . "$name" . "<" . "$from" . ">\n";
	$headers .= "X-Sender: <" . "$to" . ">\n";
	$headers .= "Return-Path: <" . "$to" . ">\n";
	$headers .= "Error-To: <" . "$to" . ">\n";
	//$headers .= "Reply-To: <will@dor2dor.com>\n";
	//$headers .= "CC: <will@dor2dor.com>\n";
	if($bcc != '')
		$headers .= "BCC: <failedpayment@saverplaces.co.uk>\n";
	$headers .= "Content-Type: text/html\n";
	mail("$recipient","$subj","$body","$headers");
}

function emailAllUsers($subject, $message, $user_id)	{
	$emails	= 	dbQuery("SELECT email FROM users WHERE id<>$user_id AND status='active' AND type='superadmin'");
	foreach($emails as $val)	{
		//$toemails	.= $val['email'].',';
		$data[0] = $val['email'];
		$data[1] = SITE_NAME;
		//$data[2] = CONTACT_EMAIL;
		$data[2] = getFieldValue($user_id,'email','users');
		$data[3] = $subject;
		$data[4] = $message;
		mailbox('',$data);
	}	

	
}

function getNotes($id)	{
	return dbQuery("SELECT title,notes FROM notes WHERE id='$id'",'single');
}

function getComment($id)	{
	return dbQuery("SELECT comment FROM comment_notes WHERE id='$id'",'single');
}

//discussion function to fetch the docs
function getDiscussionDocs($note_id)	{
	return dbQuery("SELECT * FROM notes_files WHERE notes_id='$note_id' AND status='active'");
}



function normalize_special_characters( $str ) 
{ 
    # Quotes cleanup 
    $str = ereg_replace( chr(ord("`")), "'", $str );        # ` 
    $str = ereg_replace( chr(ord("´")), "'", $str );        # ´ 
    $str = ereg_replace( chr(ord("„")), ",", $str );        # „ 
    $str = ereg_replace( chr(ord("`")), "'", $str );        # ` 
    $str = ereg_replace( chr(ord("´")), "'", $str );        # ´ 
    $str = ereg_replace( chr(ord("“")), "\"", $str );        # “ 
    $str = ereg_replace( chr(ord("”")), "\"", $str );        # ” 
    $str = ereg_replace( chr(ord("´")), "'", $str );        # ´ 

    $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 
                                'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 
                                'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 
                                'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 
                                'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' ); 
    $str = strtr( $str, $unwanted_array ); 

    # Bullets, dashes, and trademarks 
    $str = ereg_replace( chr(149), "&#8226;", $str );    # bullet • 
    $str = ereg_replace( chr(150), "&ndash;", $str );    # en dash 
    $str = ereg_replace( chr(151), "&mdash;", $str );    # em dash 
    $str = ereg_replace( chr(153), "&#8482;", $str );    # trademark 
    $str = ereg_replace( chr(169), "&copy;", $str );    # copyright mark 
    $str = ereg_replace( chr(174), "&reg;", $str );        # registration mark 

    return $str; 
}


function sendMandrillMail($to,$name,$from_email,$from_name,$subj,$body,$bcc='',$cc='')	{
	if($cc != '')
		$cc_array	= array(
					'email' => $cc,
					'name' => $name,
					'type' => 'to'
				);
	else
		$cc_array	= array();
						
	try {
		$mandrill = new Mandrill(MANDRILL_KEY);
		$message = array(
			'html' => $body,
			'text' => strip_tags($body),
			'subject' => $subj,
			'from_email' => $from_email,
			'from_name' => $from_name,
			'to' => array(
				array(
					'email' => $to,
					'name' => $name,
					'type' => 'to'
				),
				$cc_array
			),
			'headers' => array('Reply-To' => $from_email),
			'important' => false,
			'track_opens' => true,
			'track_clicks' => null,
			'auto_text' => true,
			'auto_html' => null,
			'inline_css' => null,
			'url_strip_qs' => null,
			'preserve_recipients' => null,
			'view_content_link' => null,
			'bcc_address' => null,
			'tracking_domain' => null,
			'signing_domain' => null,
			'return_path_domain' => null,
			'merge' => true,
			'merge_language' => 'mailchimp',
			'X-MC-AutoText' => true,
			'tags' => array(SITE_NAME)
			
		);
		$async = false;
		$ip_pool = 'Main Pool';
		$send_at = '';
		$result = $mandrill->messages->send($message, $async, $ip_pool, $send_at);
		//print_r($result);
		return true;
	} catch(Mandrill_Error $e) {
		// Mandrill errors are thrown as exceptions
		echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
		// A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
		throw $e;
		return false;
	}
}

//Function to create Lead email template
function createLeadEmailTemplate($firstname,$name,$email_body)	{
	return $template ='<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
  <tbody>
    <tr>
      <td align="center" valign="top">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
            <tr>
              <td align="center" bgcolor="#52BAD5" valign="top" style="background-color:#101010;padding-right:30px;padding-left:30px">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:400px">
                  <tbody>
                    <tr>
                      <td align="center" valign="top" style="padding-top:40px;padding-bottom:40px">
                        <img alt="Franchise Local" src="'.APP_URL.'/images/logo.png" height="100" width="370" style="color:#ffffff;font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:12px;font-weight:400;letter-spacing:-1px;padding:0;margin:0;text-align:center" class="CToWUd">
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
            <tr>
              <td align="center" bgcolor="#101010" valign="top" style="background-color:#101010;padding-right:30px;padding-left:30px">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tbody>
                    <tr>
                      <td align="center" valign="top"><table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:640px">
                        <tbody>
                          <tr>
                            <td align="center" valign="top"><table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#ffffff;border-collapse:separate;border-top-left-radius:4px;border-top-right-radius:4px">
                              <tbody>
                                <tr>
                                  <td align="center" valign="top" width="100%" style="padding-top:40px;padding-bottom:0">
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
        <tr>
          <td align="center" valign="top">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
              <tbody>
                <tr>
                  <td align="center" valign="top">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:700px">
                      <tbody>
                        <tr>
                          <td align="right" valign="top" width="30"><img src="'.APP_URL.'/img/background-shaddow.jpg" width="30" style="display:block" class="CToWUd">
                          </td>
                          <td valign="top" width="100%" style="padding-right:70px;padding-left:40px"><table align="left" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="left" valign="top" style="padding-bottom:20px">
                            <h1 style="color:#737373;font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:30px;font-style:normal;font-weight:600;line-height:42px;letter-spacing:normal;margin:0;padding:0;text-align:left">You have a new lead.</h1>
                          </td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" style="padding-bottom:20px">
                            <p style="color:#737373;font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:24px;padding:0;margin:0;text-align:left">Dear '.$firstname.',
                              <br>
                              <br>
                              Please find below the details from the latest person who has shown an interest in your franchise ('.$name.').
                            </p>
                          </td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" style="padding-bottom:20px">
                          </td>
                        </tr>
                        <tr></tr>
                        <tr>
                          <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:15px; line-height:26px; font-family: Arial, Helvetica, sans-serif; color:#000; font-weight:300; text-align: left; padding:5px 0; border:solid 1px #ddd; border-collapse:collapse;">'.$email_body.'
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" style="padding-bottom:40px">
                          <p style="color:#737373;font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:24px;padding:0;margin:0;text-align:left">
                            <br>
                            <br>
                            We hope this enquiry will lead to new business for your company.
                            <br><br>
                            Kind regards,
                            <br>
                            The Franchise Local Team
                            <br>
                            <a href="http://www.franchiselocal.co.uk/" style="color:#AFAFAF;text-decoration:underline" target="_blank">www.franchiselocal.co.uk</a>
                          </p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
</td>
</tr>
<tr>
  <td align="center" valign="top" style="padding-right:30px;padding-left:30px">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:640px">
      <tbody>
        <tr>
          <td valign="top" style="border-top:2px solid #f2f2f2;color:#b7b7b7;font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:12px;font-weight:400;line-height:24px;padding-top:40px;padding-bottom:20px;text-align:center">
            <p style="color:#b7b7b7;font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:12px;font-weight:400;line-height:24px;padding:0;margin:0;text-align:center">&copy; 2017 <span class="il">Franchise Local</span>, All Rights Reserved.</p>
          </td>
        </tr>
      </tbody>
    </table>
    </td>
  </tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>';
}


//Function to create Signup email template
function createSignupEmailTemplate($firstname,$email_body)	{
	$vendors	= getVendorsListFiltered('',4,'featured');
	foreach($vendors as $val)	{
		$ret	.= '<div style="float:left; margin-right:10px; border:1px solid grey;padding:4px;">
						<a href="'.APP_URL.'/'.$val['vendor_code'].'"><img src="'.APP_URL.'/upload/vendors/thumbnail/'.$val[logo].'" alt="'.$val['vendor'].'" width="120"></a>
					</div>';
	}
	return $template	= '<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                <tbody><tr>
                    <td align="center" valign="top">
                        
                        
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody><tr>
                                <td align="center" bgcolor="#101010" valign="top" style="background-color:#101010;padding-right:30px;padding-left:30px">
                                    
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:400px">
                                        <tbody><tr>
                                            <td align="center" valign="top" style="padding-top:40px;padding-bottom:40px">
                                                <img alt="Franchise Local" src="'.APP_URL.'/images/logo.png" height="100" width="370" style="color:#ffffff;font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:12px;font-weight:400;letter-spacing:-1px;padding:0;margin:0;text-align:center" class="CToWUd">    
                                            </td>
                                        </tr>
                                    </tbody></table>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td align="center" bgcolor="#101010" valign="top" style="background-color:#101010;padding-right:30px;padding-left:30px">
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody><tr>
                                            <td align="center" valign="top">
                                                
                                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:640px">
                                                    <tbody><tr>
                                                        <td align="center" valign="top">
                                                            <table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#ffffff;border-collapse:separate;border-top-left-radius:4px;border-top-right-radius:4px">
                                                                <tbody><tr>
                                                                    <td align="center" valign="top" width="100%" style="padding-top:40px;padding-bottom:0">&nbsp;</td>
                                                                </tr>
                                                            </tbody></table>
                                                        </td>
                                                    </tr>
                                                </tbody></table>
                                                
                                            </td>
                                        </tr>
                                    </tbody></table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody><tr>
                                            <td align="center" valign="top">
                                                
                                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:700px">
                                                    <tbody><tr>
                                                        <td align="right" valign="top" width="30">
                                                            <img src="'.APP_URL.'/img/background-shaddow.jpg" width="30" style="display:block" class="CToWUd">
                                                        </td>
                                                        <td valign="top" width="100%" style="padding-right:70px;padding-left:40px">
                                                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                <tbody><tr>
                                                                    <td align="left" valign="top" style="padding-bottom:20px">
                                                                        <h1 style="color:#737373;font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:30px;font-style:normal;font-weight:600;line-height:42px;letter-spacing:normal;margin:0;padding:0;text-align:left">You have successfully signed up.</h1>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left" valign="top" style="padding-bottom:15px">
                                                                        <p style="color:#737373;font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:24px;padding:0;margin:0;text-align:left">Dear '.$firstname.',<br>
<br>
Thanks for signing up to Franchise Local. Below are the details you will need to sign in to your account. We suggest you <a href="'.APP_URL.'/sign-in.html">log in</a> and update your password to something more memorable.</p>
                                                                    </td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <td align="center" valign="middle">
                                                                        <p style="color: #737373; font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif; font-size: 16px;font-weight: 600;line-height: 24px;">We thought you may be interested in the following franchises...</p>
                                                                        '.$ret.'    
                                                                    </td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <td align="left" valign="top" style="padding-bottom:20px">
                                                                        
                                                                    </td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    
                        </tr>
                        <tr>
                          <td align="center" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:15px; line-height:26px; font-family: Arial, Helvetica, sans-serif; color:#000; font-weight:300; text-align: left; padding:5px 0; border:solid 1px #ddd; border-collapse:collapse;">
                            '.$email_body.'
                          </table></td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center" style="padding-bottom:60px; padding-top:10px;" valign="top">
                                                                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                            <tbody>
                                                                            
                                                                            <tr>
                                                                                <td align="center" valign="middle">
                                                                                    
                                                                                    <a href="'.APP_URL.'/sign-in.html" style="background-color:#ffb700;border-collapse:separate;border-top:20px solid #ffb700;border-right:40px solid #ffb700;border-bottom:20px solid #ffb700;border-left:40px solid #ffb700;border-radius:3px;color:#ffffff;display:inline-block;font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:16px;font-weight:600;letter-spacing:.3px;text-decoration:none" target="_blank">Sign in to your account</a>
                                                                                    
                                                                                </td>
                                                                            </tr>
                                                                            
                                                                        </tbody></table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left" valign="top" style="padding-bottom:40px">
                                                                        <p style="color:#737373;font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:24px;padding:0;margin:0;text-align:left">
                                                                          
                                                                          <br>
                                                                          <br>
                                                                          Kind regards,
                                                                          <br>
                                                                          The Franchise Local Team

                                                                          <br>
                                                                          
                                                                         
                                                                      <a href="http://www.franchiselocal.co.uk/" style="color:#AFAFAF;text-decoration:underline" target="_blank">www.franchiselocal.co.uk</a></p>
                                                                    </td>
                                                                </tr>
                                                                
                                                            </tbody></table>
                                                        </td>
                                                    </tr>
                                                </tbody></table>
                                                
                                            </td>
                                        </tr>
                                    </tbody></table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top" style="padding-right:30px;padding-left:30px">
                                    
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:640px">
                                        <tbody><tr>
                                            <td valign="top" style="border-top:2px solid #f2f2f2;color:#b7b7b7;font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:12px;font-weight:400;line-height:24px;padding-top:40px;padding-bottom:20px;text-align:center">
                                                <p style="color:#b7b7b7;font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:12px;font-weight:400;line-height:24px;padding:0;margin:0;text-align:center">&copy; 2017 <span class="il">Franchise Local</span>, All Rights Reserved.</p></td>
                                        </tr>
                                    </tbody></table>
                                    
                                </td>
                            </tr>
                        </tbody></table>
                        
                    </td>
                </tr>
            </tbody></table>';
}


//Function to create Signup email template
function createAdminSignupEmailTemplate($firstname,$email_body)	{
	return $template	= '<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                <tbody><tr>
                    <td align="center" valign="top">
                        
                        
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody><tr>
                                <td align="center" bgcolor="#101010" valign="top" style="background-color:#101010;padding-right:30px;padding-left:30px">
                                    
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:400px">
                                        <tbody><tr>
                                            <td align="center" valign="top" style="padding-top:40px;padding-bottom:40px">
                                                <img alt="Franchise Local" src="'.APP_URL.'/images/logo.png" height="100" width="370" style="color:#ffffff;font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:12px;font-weight:400;letter-spacing:-1px;padding:0;margin:0;text-align:center" class="CToWUd">    
                                            </td>
                                        </tr>
                                    </tbody></table>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td align="center" bgcolor="#101010" valign="top" style="background-color:#101010;padding-right:30px;padding-left:30px">
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody><tr>
                                            <td align="center" valign="top">
                                                
                                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:640px">
                                                    <tbody><tr>
                                                        <td align="center" valign="top">
                                                            <table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#ffffff;border-collapse:separate;border-top-left-radius:4px;border-top-right-radius:4px">
                                                                <tbody><tr>
                                                                    <td align="center" valign="top" width="100%" style="padding-top:40px;padding-bottom:0">&nbsp;</td>
                                                                </tr>
                                                            </tbody></table>
                                                        </td>
                                                    </tr>
                                                </tbody></table>
                                                
                                            </td>
                                        </tr>
                                    </tbody></table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody><tr>
                                            <td align="center" valign="top">
                                                
                                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:700px">
                                                    <tbody><tr>
                                                        <td align="right" valign="top" width="30">
                                                            <img src="'.APP_URL.'/img/background-shaddow.jpg" width="30" style="display:block" class="CToWUd">
                                                        </td>
                                                        <td valign="top" width="100%" style="padding-right:70px;padding-left:40px">
                                                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                <tbody><tr>
                                                                    <td align="left" valign="top" style="padding-bottom:20px">
                                                                        <h1 style="color:#737373;font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:30px;font-style:normal;font-weight:600;line-height:42px;letter-spacing:normal;margin:0;padding:0;text-align:left">New Sign up.</h1>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left" valign="top" style="padding-bottom:20px">
                                                                        <p style="color:#737373;font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:24px;padding:0;margin:0;text-align:left">Dear Admin,<br>
<br>
Please find below the sign up details.</p>
                                                                    </td>
                                                                </tr>
                                                                
                                                                
                                                                <tr>
                                                                    <td align="left" valign="top" style="padding-bottom:20px">
                                                                        
                                                                    </td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    
                        </tr>
                        <tr>
                          <td align="center" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:15px; line-height:26px; font-family: Arial, Helvetica, sans-serif; color:#000; font-weight:300; text-align: left; padding:5px 0; border:solid 1px #ddd; border-collapse:collapse;">
                            '.$email_body.'
                          </table></td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left" valign="top" style="padding-bottom:40px">
                                                                        <p style="color:#737373;font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:24px;padding:0;margin:0;text-align:left">
                                                                          
                                                                          <br>
                                                                          <br>
                                                                          Kind regards,
                                                                          <br>
                                                                          The Franchise Local Team

                                                                          <br>
                                                                          
                                                                         
                                                                      <a href="http://www.franchiselocal.co.uk/" style="color:#AFAFAF;text-decoration:underline" target="_blank">www.franchiselocal.co.uk</a></p>
                                                                    </td>
                                                                </tr>
                                                                
                                                            </tbody></table>
                                                        </td>
                                                    </tr>
                                                </tbody></table>
                                                
                                            </td>
                                        </tr>
                                    </tbody></table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top" style="padding-right:30px;padding-left:30px">
                                    
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:640px">
                                        <tbody><tr>
                                            <td valign="top" style="border-top:2px solid #f2f2f2;color:#b7b7b7;font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:12px;font-weight:400;line-height:24px;padding-top:40px;padding-bottom:20px;text-align:center">
                                                <p style="color:#b7b7b7;font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:12px;font-weight:400;line-height:24px;padding:0;margin:0;text-align:center">&copy; 2016 <span class="il">Franchise Local</span>, All Rights Reserved.</p></td>
                                        </tr>
                                    </tbody></table>
                                    
                                </td>
                            </tr>
                        </tbody></table>
                        
                    </td>
                </tr>
            </tbody></table>';
}
?>