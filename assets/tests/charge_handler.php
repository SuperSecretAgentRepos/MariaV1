<?php

//Send curl request to sendgrid
echo "Test started <br>";
//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

$email = $_POST['receipt-email'];
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.sendgrid.com/v3/contactdb/recipients",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "[{\"email\":\"$email\"}]",
  CURLOPT_HTTPHEADER => array(
    "authorization: Bearer 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",
    "content-type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}

include("../stripe-php-6.4.1/init.php");
// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey("sk_test_moePw6kJoAAfyo4cWlIgxP8i");


// Token is created using Checkout or Elements!
// Get the payment token ID submitted by the form:
$token = $_POST['stripeToken'];

// Charge the user's card:
$charge = \Stripe\Charge::create(array(
  "amount" => 999,
  "currency" => "usd",
  "description" => "Workout Guide",
  "source" => $token,
  "receipt_email" => $_POST['receipt-email'],
));

?>