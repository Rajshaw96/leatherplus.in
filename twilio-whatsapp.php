<?php

// Update the path below to your autoload.php,
// see https://getcomposer.org/doc/01-basic-usage.md

require_once("plugins/twilio/src/Twilio/autoload.php");

use Twilio\Rest\Client;

 $sid    = "AC61f137ab726b59e94400c6a9fdabbcf2";
    $token  = "6c77ad4942b83226dafb09824a6e380d";
    $twilio = new Client($sid, $token);

    $message = $twilio->messages
      ->create("whatsapp:+919044582946", // to
        array(
          "from" => "whatsapp:+14155238886",
          "body" => "Your appointment is coming up on July 21 at 3PM"
        )
      );

print($message->sid);