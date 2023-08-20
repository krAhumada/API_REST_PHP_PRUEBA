<?php 

require_once './config.php';

$endpoint = "http://localhost/delfosti-prueba/payments/processPayment";

?>

<form action="<?= $endpoint; ?>" method="post">
    <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="<?php echo $stripe['publishable_key']; ?>"
        data-description="Access for a year"
        data-amount="5000"
        data-locale="auto"></script>
</form>