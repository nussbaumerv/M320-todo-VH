<script src="https://www.google.com/recaptcha/enterprise.js?render=6LfQrVEpAAAAAJfbIKgkHv3mKzDlZtRMQLW4yzbG"></script>
<script>
grecaptcha.enterprise.ready(function() {
    grecaptcha.enterprise.execute('6LfQrVEpAAAAAJfbIKgkHv3mKzDlZtRMQLW4yzbG', {action: 'login'}).then(function(token) {
       ...
    });
});
</script>
<?php
include "connect.php";
include("social-login/config-register.php");
if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql_select = "SELECT * FROM users WHERE email = '$email'";
    $result_select = mysqli_query($connect, $sql_select);
    $row = mysqli_fetch_assoc($result_select);
    
    
            if($row['email'] != false) {
            echo '<br>Diese E-Mail-Adresse ist bereits vergeben';
            }
            else{
    
    
    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
   $result = mysqli_query($connect, $sql);
   if($result){
    header("login.php");
   }
   else{
       echo "Something went wrong";
   }
            }
    
}
?>
<html>
    <head>
            <html lang="en">
    <meta charset="utf-8"/>
    <title>V-Todo</title>
    <link rel="apple-touch-icon" sizes="128x128" href="icon.png">
    <link rel="shortcut icon" href="icon.png" type="img/vnd.microsoft.icon"/>
    <link rel="manifest" href="manifest.webmanifest">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    body {
        font-family: arial;
        margin: 0px;
        text-align: center;
        background-color: #e3e3e3;
    }

    .container{
        min-height:100%;
    }

    input[type="email"],
    input[type="password"] {
        border: solid;
        border-color: black;
        margin-bottom: 1vh;
        font-size: 16px;
        opacity: 0.97;
        border-radius: 5px;
        color: black;
        padding: 10px 60px 10px 20px;
    }

    input[type="email"]:focus,
    input[type="password"]:focus {
        outline: none;
        background-color: #e3e3e3;
    }

    #button {
        border: none;
        -webkit-appearance: none;
        background-color: #6200E8;
        margin-bottom: 1vh;
        font-size: 16px;
        font-weight: normal;
        border-radius: 20px;
        padding: 10px 30px;
        color: white;
        cursor: pointer;
    }

    #button:hover {
        opacity: 0.9;
    }

    #button:active {
        opacity: 0.5;
    }

    .register {
        color: grey;
        font-size: 14px;
    }

    .register a {
        color: grey;
    }
    </style>

</head>

<body>
<div class="container">
    <br>
    <h1>Registrieren</h1>
    <form action="" method="post">
        <input name="email" type="email" placeholder="Email"> <br>
        <input name="password" type="password" placeholder="Password"> <br><br>
        <input id="button" name="submit" value="Registrieren" type="submit">

    </form>
    ––– OR –––
    <br>
    <br>

    <?php   echo '<a href="'.$google_client->createAuthUrl().'"><img src="https://developers.google.com/static/identity/images/branding_guideline_sample_lt_rd_lg.svg"></a>'; ?>
    <br><br>

    <p class="register">Bereits einen Account? <a href="login.php">Login</a></p>
</div>
<?php include("footer.php"); ?>
</body>

</html>