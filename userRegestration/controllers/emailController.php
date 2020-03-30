<?php 
require_once '../vendor/autoload.php';
require_once '../userRegestration/config/constants.php';

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
  ->setUsername(EMAIL)
  ->setPassword(PASSWORD)
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);



function sendVerificationEmail($email, $token){
global $mailer;

    $body = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">    
        <title>veryfi emeil</title>
    </head>
    <body>
        <div class="wrapper">
            <p>
                thank you for sigining up in our site please click on the link to veryfy ur status
                thank .
            </p>
            <a href="http://www.demo.io/userRegestration/index.php?token=' . $token . '">veryfi your email address</a>
        </div>
    </body>
    </html>
     ';


// Create a message
$message = (new Swift_Message('email verification mail'))
  ->setFrom(EMAIL)
  ->setTo($email)
  ->setBody($body, 'text/html');

// Send the message
$result = $mailer->send($message);

}

function sendPasswordResetLink($email, $token){
  

  global $mailer;

    $body = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">    
        <title>veryfi emeil</title>
    </head>
    <body>
        <div class="wrapper">
            <p>
               Hello there, forget your password? well that happen sometime, dont worry 
               just click on the reset-my-password 
            </p>
            <a href="http://www.demo.io/userRegestration/reset_password.php?password-token=' . $token . '">reset-my-password</a>
        </div>
    </body>
    </html>
     ';


// Create a message
$message = (new Swift_Message('Reset your password'))
  ->setFrom(EMAIL)
  ->setTo($email)
  ->setBody($body, 'text/html');

// Send the message
$result = $mailer->send($message);



}