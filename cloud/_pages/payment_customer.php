<?php

require_once "../lib/braintree/Braintree.php";

Braintree_Configuration::environment("sandbox");
Braintree_Configuration::merchantId("53wswq86yfwrxb3t");
Braintree_Configuration::publicKey("gk9d7v8mvccvbsdc");
Braintree_Configuration::privateKey("c16fd205e6864519268c889b2b2ba7cf");

$result = Braintree_Customer::create(array(
   "firstName" => 'Adarsh',
    "lastName" => 'Peethambaran',
    "creditCard" => array(
        "number" => '4111111111111111',
        "expirationMonth" => '12',
        "expirationYear" => '2016',
        "cvv" => '200',
        "billingAddress" => array(
            "postalCode" => 'AL95EG'
        )
    )
));

if ($result->success) {
    echo("Success! Customer ID: " . $result->customer->id . "<br/>");
    echo("<a href='./subscription.php?customer_id=" . $result->customer->id . "'>Create subscription for this customer</a>");
} else {
    echo("Validation errors:<br/>");
    foreach (($result->errors->deepAll()) as $error) {
        echo("- " . $error->message . "<br/>");
    }
}
?>
