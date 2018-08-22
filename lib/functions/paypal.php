<?

//--------------------------------------------------------------------------------------------------------------
/*
	Creates the Paypal subscribe button
	Inputs :
		amount : the amount
		adId : the advertisement id
		subId : the sub-id (a random string)
		buttonString : the label of the pay button, eg 'Subscribe'
	Outputs :
		the form string
*/
function ppCreateSubButton($amount, $adId, $subId, $buttonString, $nextUrl) {
	$ppAction = (PAYMENT_MODE=="live" ? "https://www.paypal.com/cgi-bin/webscr" : "https://www.sandbox.paypal.com/cgi-bin/webscr");

	$ppParams = array();
	$ppParams['cmd'] = "_xclick-subscriptions";
	$ppParams['business'] = PP_EMAIL;
	$ppParams['item_name'] = "Advertisement";
	$ppParams['a3'] = $amount;
	#$ppParams['p3'] = 1;
	$ppParams['p3'] = 30;
	//$ppParams['t3'] = "M";
	$ppParams['t3'] = "D";
	$ppParams['src'] = "1";
	$ppParams['no_note'] = "1";
	$ppParams['custom'] = $adId;
	$ppParams['invoice'] = $subId;
	$ppParams['currency_code'] = CURRENCY_CODE;

	$ppParams['rm'] = "2";
	$ppParams['return'] = $nextUrl;
	$ppParams['cancel_return'] = $nextUrl;

	$str = '<form action="' . $ppAction . '" method="POST" style="display:inline;">';
	foreach($ppParams as $key=>$value)
		$str .= "<input type=\"hidden\" name=\"$key\"  value=\"$value\">";
	$str .= '<input type="submit" value="'.$buttonString.'">';
	$str .= '</form>';
	return $str;
}
//--------------------------------------------------------------------------------------------------------------

/*
	The Paypal IPN function
	** PLEASE DON'T CALL THIS FUNCTION DIRECTLY **
*/

function ppIPN() {
	// read the post from PayPal system and add 'cmd'
	$req = 'cmd=_notify-validate';

	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$req .= "&$key=$value";
	}

	// post back to PayPal system to validate
	$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
	$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);

	// assign posted variables to local variables
	$item_name = $_POST['item_name'];
	$item_number = $_POST['item_number'];
	$payment_status = $_POST['payment_status'];
	$payment_amount = $_POST['mc_gross'];
	$payment_currency = $_POST['mc_currency'];
	$txn_id = $_POST['txn_id'];
	$receiver_email = $_POST['receiver_email'];
	$payer_email = $_POST['payer_email'];

	$ad_id = $_POST['custom'];
	$txn_type = $_POST['txn_type'];

	if (!$fp) {
		// HTTP ERROR
	} else {
		fputs ($fp, $header . $req);
		while (!feof($fp)) {
			$res = fgets ($fp, 1024);
			if (strcmp ($res, "VERIFIED") == 0) {
				// check the payment_status is Completed
				// check that txn_id has not been previously processed
				// check that receiver_email is your Primary PayPal email
				// check that payment_amount/payment_currency are correct
				// process payment

				// subscription signup
				if($txn_type=="subscrsignup") {
					$dbFields = array();
					$dbFields['subtxnid'] = $txn_id;
					$dbFields['subgateway'] = "paypal";
					$dbFields['subdate'] = "now()";
					$dbFields['substatus'] = "verified";

					$specialFields = array("subdate");
					dbPerform("advertisements", $dbFields, $specialFields, "id='{$ad_id}'");
				} else {

					if($txn_type=="subscr_failed" || $txn_type=="subscr_cancel" || $txn_type=="subscr_payment")

					if($txn_type=="subscr_failed")
						$dbStatus = "declined";
					elseif($txn_type=="subscr_cancel")
						$dbStatus = "cancelled";
					elseif($txn_type=="subscr_payment")
						$dbStatus = "verified";

					$dbFields = array();
					$dbFields['adv_id'] = $ad_id;
					$dbFields['txndate'] = "now()";
					$dbFields['txnid'] = $txn_id;
					$dbFields['status'] = $dbStatus;

					$specialFields = array("subdate");
					dbPerform("subscription_renewals", $dbFields, $specialFields);

					// if failed or cancelled, update the ad table
					if($txn_type=="subscr_failed" || $txn_type=="subscr_cancel") {
						if($txn_type=="subscr_failed")
							$query = "update advertisements set substatus='declined' where id='{$ad_id}'";
						else
							$query = "update advertisements set substatus='cancelled' where id='{$ad_id}'";

						dbQuery($query);
					}
				}
			}
			else if (strcmp ($res, "INVALID") == 0) {
				// log for manual investigation
			}
		}
		fclose ($fp);
	}
}








function ppCheckoutButton($paymentMode, $ppEmail, $amount, $txnId, $buttonString, $returnUrl, $cancelUrl) {
	$ppAction = ($paymentMode=="live" ? "https://www.paypal.com/cgi-bin/webscr" : "https://www.sandbox.paypal.com/cgi-bin/webscr");

	$ppParams = array();
	$ppParams['cmd'] = "_xclick";
	$ppParams['business'] = $ppEmail;
	$ppParams['item_name'] = "Walk Of Life Program";
	$ppParams['invoice'] = $txnId;
	$ppParams['custom'] = $txnId;
	$ppParams['currency_code'] = "GBP";
	$ppParams['amount'] = $amount;

	$ppParams['rm'] = "2";
	$ppParams['return'] = $returnUrl;
	$ppParams['cancel_return'] = $cancelUrl;


	$str = '<form name="ppForm" id="ppForm" action="' . $ppAction . '" method="POST" style="display:inline;">';
	foreach($ppParams as $key=>$value)
		$str .= "<input type=\"hidden\" name=\"$key\"  value=\"$value\">";
	$str .= '<input type="submit" value="'.$buttonString.'">';
	$str .= '</form>';
	return $str;
}
?>