<?php

require_once "../lib/braintree/Braintree.php";

Braintree_Configuration::environment("sandbox");
Braintree_Configuration::merchantId("53wswq86yfwrxb3t");
Braintree_Configuration::publicKey("gk9d7v8mvccvbsdc");
Braintree_Configuration::privateKey("c16fd205e6864519268c889b2b2ba7cf");

$result = Braintree_Transaction::sale(
  array(
    'customerId' => '14551579',
    'amount' => '100.00',
	'options' => array(
    	'submitForSettlement' => true
    )
  )
);

if ($result->success) {
   $transaction = $result->transaction;
   echo $transaction->status;
} else {
    echo("Validation errors:<br/>");
    foreach (($result->errors->deepAll()) as $error) {
        echo("- " . $error->message . "<br/>");
    }
}
?>
