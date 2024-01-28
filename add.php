<html>

<head>
<html lang="en">
    <meta charset="utf-8" />
    <title>V-Todo</title>
    <link rel="apple-touch-icon" sizes="128x128" href="icon.png">
    <link rel="shortcut icon" href="icon.png" type="img/vnd.microsoft.icon" />
    <link rel="manifest" href="manifest.webmanifest">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: arial;
            text-align: center;
            margin:0px;
        }

        a {
            padding: 10px;
            background-color: #c9c9c9;
            text-decoration: none;
            color:black;
            border:solid;
            border-color:grey;
        }
    </style>
</head>
<?php
session_start();
include("connect.php");
$id = $_GET['id'];
if ($id == "") {
    header("Location: admin.php");
}

if ($_GET['add'] == 1) {
    if (!isset($_SESSION['userid'])) {
        header("Location: login.php?add=1&id=$id");
    } else {
        $user_id = $_SESSION['userid'];
        $sql_select = "SELECT * FROM tables WHERE id = '$id'";
        $result_select = mysqli_query($connect, $sql_select);
        $row = mysqli_fetch_assoc($result_select);

        if ($row['shared'] == 0) {
            echo "<h1>Diese To Do Liste ist privat.</h1>";
            exit;
        }
        $name = $row['name'];

        $sql_insert = "INSERT INTO tables (user_id, name, shared, shared_id) VALUES ('$user_id', '$name', '2', '$id')";
        $result_insert = mysqli_query($connect, $sql_insert);

        $sql_update = "UPDATE tables SET shared = '3' WHERE id = '$id'";
        $result_update = mysqli_query($connect, $sql_update);
        if ($result_update) {
            header('Location: admin.php');
        } else {
            echo "Something went wrong";
            exit;
        }
    }
}
?>

<body>
    <div id="container"> <br> <br> <br>
    <a href="add.php?add=1&id=<?php echo $id ?>">Zu deinen To Do Listen hinzufügen</a> <br> <br> <br>
    <a href="todo.php?id=<?php echo $id ?>">To Do Liste ohne Registrierung nutzem</a>
    </div>
</body>

</html>