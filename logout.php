
<?php

//logout.php

session_start();

include('social-login/config-sign-in.php');

//Reset OAuth access token
$google_client->revokeToken();

//Destroy entire session data.
session_destroy();

//redirect page to index.php
header('Location: login.php');

?>