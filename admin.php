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
            background-color: #e3e3e3;
            font-family: arial;
            margin: 0px;
            text-align: center;
        }

        .container {
            min-height: 100%;
        }

        a {
            color: black;
            text-decoration: none;
        }

        .one {
            text-align: left;
            background-color: #c9c9c9;
            height: 60px;
            line-height: 60px;
            padding: 0 0 0 1vw;
            margin-bottom: 2px;
        }

        #shared {
            background-color: #b5b5b5;
        }

        #deleted {
            text-decoration: line-through;
            background-color: #a3a3a3;
        }

        #deleted input:focus {
            color: #b80000;
        }

        form {
            padding: 0px;
            margin: 0px;
        }

        #del {
            color: black;
            float: right;
            margin-right: 15px;
            padding-top: 15px;
            border: 0px;
            background-color: transparent;
            font-size: 30px;
            cursor: pointer;
        }

        #del:focus {
            color: #636363;
            -webkit-animation: rotate 0.5s;
            transform-origin: 50% 65%;
        }

        #del:active {
            color: red;
        }

        @-webkit-keyframes rotate {
            0% {
                -webkit-transform: rotate(0);
            }

            100% {
                -webkit-transform: rotate(-90deg);
            }
        }

        #add_form {
            text-align: center;
            position: fixed;
            left: 25vw;
            bottom: 10px;
        }

        #new_product {
            border: solid;
            border-color: black;
            margin-bottom: 1vh;
            font-size: 16px;
            opacity: 0.97;
            border-radius: 5px;
            color: black;
            width: 50vw;
            padding: 20px 30px;
        }

        #new_submit {
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

        #new_submit:hover {
            opacity: 0.9;
        }

        #new_submit:active {
            opacity: 0.5;
        }


        @media only screen and (max-width: 600px) {
            .zo {
                left: 0px;
            }

            .one {
                width: 95vw;
                padding: 0 0 0 5vw;
            }

            #del {
                margin-right: 0vw;
                padding-top: 10px;
            }

            #add_form {
                left: 15vw;
            }

            #new_product {
                width: 70vw;
                padding: 10px 20px;
            }

            #new_submit {
                padding: 5px 20px;
            }
        }
    </style>
</head>
<div class="container">
    <?php
    session_start();
    require_once "connect.php";


    if (!isset($_SESSION['userid'])) {
        header("Location: login.php");
    }

    $id = $_SESSION['userid'];
    $password = $_SESSION['password'];


    $user = "SELECT * FROM users WHERE id = '$id'";

    $result_user = mysqli_query($connect, $user);

    $row_user = mysqli_fetch_assoc($result_user);

    if (!$result_user) {
        echo "<script> alert('Daten konnten nicht geladen Werden.'); </script>";
    }

    $pwd = $row_user['password'];

    $id = $row_user['id'];

    $tabels = "SELECT * FROM tables WHERE user_id = '$id' ORDER BY id DESC";
    $result_tabels = mysqli_query($connect, $tabels);

    include("menu.php");

    if (!$result_tabels) {
        echo "<script> alert('Daten konnten nicht geladen Werden.'); </script>";
    }

    if (isset($_POST['submit_del'])) {
        $id = $_POST['id'];
        $del = "DELETE FROM tables WHERE id = '$id'";
        $del_table = "DELETE FROM todos WHERE table_id = '$id'";
        $pdelete = mysqli_query($connect, $del);
        $delete_table = mysqli_query($connect, $del_table);
        echo ("<meta http-equiv='refresh' content='0'>");
    }
    if (isset($_POST['new_submit'])) {
        $name = $_POST['name'];
        $create = "INSERT INTO tables (user_id, name, shared, shared_id) VALUES ('$id', '$name', '0', '0')";
        $pcreate = mysqli_query($connect, $create);
        echo ("<meta http-equiv='refresh' content='0'>");
    }

    echo "<br> <h1>Deine Listen</h1>";


    while ($row_tabels = mysqli_fetch_assoc($result_tabels)) {
        $id = $row_tabels['id'];
        $name = $row_tabels['name'];
        $shared = $row_tabels['shared'];

        if ($shared == 2) {
            $shared_id = $row_tabels['shared_id'];

            echo "<a href='todo.php?id=" . $shared_id . "'><div class='one' id='shared'>
        <form method='POST'>
        <input type='hidden' name='id' value='" . $row_tabels['id'] . "'>
        <input class='material-icons' id='del' name='submit_del' type='submit' value='&#xe92e;'>
        </form>";
        } else {
            echo "<a href='todo.php?id=" . $id . "'><div class='one'>
        <form method='POST'>
        <input type='hidden' name='id' value='" . $row_tabels['id'] . "'>
        <input class='material-icons' id='del' name='submit_del' type='submit' value='&#xe92e;'>
        </form>";
        }

        echo $name;
        echo "</div></a>";
    }

    if (!$password == $pwd) {
        header("Location: login.php");
    }
    ?>
    <form id="add_form" action="" method="post">
        <input required id="new_product" name="name" placeholder="Neue Liste erstellen"> <br>
        <input id="new_submit" type="submit" value="Speichern" name="new_submit">
    </form>

</div>
<?php include("footer.php"); ?>

</html>