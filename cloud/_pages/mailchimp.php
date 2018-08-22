<?php
$api_key = "5a3eb55c3b6ecc333c90a778f6744f1a-us9";
$list_id = "0ee51a6c6f";
 
require('../lib/mailchimp/Mailchimp.php');

$Mailchimp = new Mailchimp( $api_key );
$Mailchimp_Lists = new Mailchimp_Lists( $Mailchimp );

try {
    $subscriber = $Mailchimp_Lists->subscribe( $list_id, array( 'email' => 'adarsh@freedomsites.co.uk' ) );
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}


 
if ( ! empty( $subscriber['leid'] ) ) {
   echo "success";
   echo '<pre>';
   print_r($subscriber);
}
else
{
    echo "fail";
}
 
?>