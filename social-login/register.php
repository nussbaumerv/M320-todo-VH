<?php

//index.php

//Include Configuration File
include('config-register.php');
include('connect.php');

//This $_GET["code"] variable value received after user has login into their Google Account redirct to PHP script then this variable value has been received
if(isset($_GET["code"]))
{
 //It will Attempt to exchange a code for an valid authentication token.
 $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

 //This condition will check there is any error occur during geting authentication token. If there is no any error occur then it will execute if block of code/
 if(!isset($token['error']))
 {
  //Set the access token used for requests
  $google_client->setAccessToken($token['access_token']);

  //Store "access_token" value in $_SESSION variable for future use.
  $_SESSION['access_token'] = $token['access_token'];

  //Create Object of Google Service OAuth 2 class
  $google_service = new Google_Service_Oauth2($google_client);

  //Get user profile data from google
  $data = $google_service->userinfo->get();

   $email = $data['email'];
   $username = $data['name'];
   $password = $token['access_token'];
   $password = password_hash($password, PASSWORD_DEFAULT);
   
    $sql_select = "SELECT * FROM users WHERE email = '$email'";
    $result_select = mysqli_query($connect, $sql_select);
    $row = mysqli_fetch_assoc($result_select);
    
    
            if($row['email'] != false) {
                header("Location: https://todo.valentin-nussbaumer.com/login.php?code=eror");
            }
            else{
    
    
   $sql = "INSERT INTO users (username, email, password, method) VALUES ('$username', '$email', '$password', 'google')";
    $result = mysqli_query($connect, $sql);
    if(!$result){
        echo "Something went wrong";
    }
    $sql_select = "SELECT * FROM users WHERE email = '$email'"; 
    $result_select = mysqli_query($connect, $sql_select);
    $row = mysqli_fetch_assoc($result_select);
    
    $_SESSION['userid'] = $row['id'];
    $_SESSION['method'] = $row['method'];
    $_SESSION['password'] = $row['password'];
    header("Location: https://todo.valentin-nussbaumer.com/login.php");
            }
    
    
   
 }
}

if(!isset($_SESSION['access_token']))
{
 $login_button = '<a href="'.$google_client->createAuthUrl().'"><img src="sign-in-with-google.png" /></a>';
}
