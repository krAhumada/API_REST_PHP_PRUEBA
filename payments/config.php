<?php

require_once('vendor/autoload.php');

$stripe = array(
    'secret_key' => 'sk_test_51Ngx8tGUX0tivtVQiSWRaOR0ONz082cOZQ1NnQZCHh1t6eqrEC2Woj9eQ1uCsQeTWPoHdZDqedlyXHT4kbVPjLMr00fRDN3NR7',
    'publishable_key' => 'pk_test_51Ngx8tGUX0tivtVQJyCQFv5pzvBQWSYcWHBMKbX2kuoSbFazqHdaybDc50P0iWZyI1NDyENzCMuQABHowwPoGwJ400Soz8g2BN',
);

\Stripe\Stripe::setApiKey($stripe['secret_key']);



?>