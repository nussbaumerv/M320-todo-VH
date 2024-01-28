<script src="https://www.google.com/recaptcha/enterprise.js?render=//aufgrund von privatsphaere ausgeblendet"></script>
<script>
grecaptcha.enterprise.ready(function() {
    grecaptcha.enterprise.execute('//aufgrund von privatsphaere ausgeblendet', {
        action: 'login'
    }).then(function(token) {
        ...
    });
});
</script>
<?php
session_start();
include("connect.php");
include('social-login/config-sign-in.php');
echo $_SESSION['email'];

if ($_SESSION['userid']) {
    header("Location: admin.php");
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";

    $result = mysqli_query($connect, $sql);

    if (!$result) {
        echo "<script> alert('Daten konnten nicht geladen Werden.'); </script>";
    }

    $row = mysqli_fetch_assoc($result);
    

    $pwd = $row['password'];

    if (password_verify($password, $pwd)) {
        $_SESSION['password'] = $pwd;
        $_SESSION['userid'] = $row['id'];
        if (isset($_GET['add'])) {
            $id = $_GET['id'];
            header("Location: add.php?add=1?id=$id");
        } else {
            header("Location: admin.php");
        }
    } else {
            if($row['method'] == "google"){
        echo '<fc><br>Sie haben sich mit GOOGLE eingelogt</fc>';
    }
    else{
        echo '<fc><br>Falsches Passwort</fc>
    <script> document.getElementById("pw").value = "";
    document.getElementById("pw").placeholder = "Falsches Passwort"; </script>';
    }
    }
}
?>
<html>

<head>
    <html lang="en">
    <meta charset="utf-8" />
    <title>V-Todo | The revolutionary todo app</title>
    <meta name="description" content="With V-Todo you can easily create shareable to-do lists for free.">
    <link rel="apple-touch-icon" sizes="128x128" href="icon.png">
    <link rel="shortcut icon" href="icon.png" type="img/vnd.microsoft.icon" />
    <link rel="manifest" href="manifest.webmanifest">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:400" />
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
    <h1>Login</h1>
    <form action="" method="post">
        <input name="email" type="email" placeholder="Email"> <br>
        <input name="password" type="password" placeholder="Password"> <br><br>
        <input id="button" name="submit" value="Login" type="submit">

    </form>
    ––– OR –––
    <br>
    <br>

    <?php   echo '<a href="'.$google_client->createAuthUrl().'"><img src="https://developers.google.com/static/identity/images/branding_guideline_sample_lt_rd_lg.svg"></a>'; ?>
    <br><br>

    <p class="register">Noch kein Account? <a href="register.php">Registrieren</a></p>
</div>
<?php include("footer.php"); ?>

</body>


</html>