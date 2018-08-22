<?php

require_once "../lib/braintree/Braintree.php";

Braintree_Configuration::environment("sandbox");
Braintree_Configuration::merchantId("53wswq86yfwrxb3t");
Braintree_Configuration::publicKey("gk9d7v8mvccvbsdc");
Braintree_Configuration::privateKey("c16fd205e6864519268c889b2b2ba7cf");

try {
    $customer_id = '27332313';
    $customer = Braintree_Customer::find($customer_id);
    $payment_method_token = $customer->creditCards[0]->token;

    $result = Braintree_Subscription::create(array(
        'paymentMethodToken' => $payment_method_token,
        'planId' => '97r2'
    ));

    if ($result->success) {
        echo("Success! Subscription " . $result->subscription->id . " is " . $result->subscription->status);
    } else {
        echo("Validation errors:<br/>");
        foreach (($result->errors->deepAll()) as $error) {
            echo("- " . $error->message . "<br/>");
        }
    }
} catch (Braintree_Exception_NotFound $e) {
    echo("Failure: no customer found with ID " . $_GET["customer_id"]);
}
?>
