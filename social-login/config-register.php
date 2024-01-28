<?php

//config.php

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();


//Set the OAuth 2.0 Client ID
$google_client->setClientId('//aufgrund von privatsphaere ausgeblendet

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('//aufgrund von privatsphaere ausgeblendet

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('https://todo.valentin-nussbaumer.com/social-login/register.php');

//
$google_client->addScope('email');

$google_client->addScope('profile');

//start session on web page
session_start();

?>