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
        margin: 0px;
        text-align: center;
        background-color: #e3e3e3;
    }

    .container{
        min-height:100%;
    }


    .share_button {
        color: #545352;
        float: right;
        margin: 0;
        position: absolute;
        top: 30px;
        right: 30px;
        font-size: 40px;
        cursor: pointer;
    }

    select {
        border: solid;
        border-color: black;
        font-size: 16px;
        border-radius: 5px;
        color: black;
        padding: 10px 20px;
        margin-bottom: 1vh;
    }

    .one {
        text-align: left;
        height: 60px;
        line-height: 60px;
        padding: 0 0 0 1vw;
        margin-bottom: 2px;
        background-color: #c9c9c9;
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
        color: green;
    }

    .expand_button {
        color: black;
        float: right;
        margin-right: 15px;
        padding-top: 15px;
        border: 0px;
        background-color: transparent;
        font-size: 30px;
        cursor: pointer;
        text-decoration: none;
    }

    @-webkit-keyframes rotate {
        0% {
            -webkit-transform: rotate(0);
        }

        100% {
            -webkit-transform: rotate(360deg);
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

    p {
        position: absolute;
        left: 20px;
        top: 20px;
        color: grey;
    }

    .info{
        font-size: 10px;
        padding:5px;
        background-color: #6200E8;
        color:white;
        border-radius: 5px;
    }
    </style>
</head>

<body>
<div class="container">
    <br>
    <div id="list">
        <?php
        session_start();

        $table_id = $_GET['id'];
        if ($table_id == "") {
            header("Location: admin.php");
        }

        require_once "connect.php";
        include("alert.php");

        $id = $_SESSION['userid'];
        $password = $_SESSION['password'];

        $user = "SELECT * FROM users WHERE id = '$id'";

        $result_user = mysqli_query($connect, $user);

        $row_user = mysqli_fetch_assoc($result_user);

        if (!$result_user) {
            echo "<script> alert('Daten konnten nicht geladen Werden.'); </script>";
            exit;
        }
        $pwd = $row_user['password'];



        $table_sql = "SELECT * FROM tables WHERE id = '$table_id'";

        $result_table = mysqli_query($connect, $table_sql);
        $row_table = mysqli_fetch_assoc($result_table);
        if ($row_table['user_id'] == $id) {
            if ($password != $pwd) {
                header("Location: login.php");
            }
            include("menu.php");
            include("share_popup.php");
        } else {
            if ($row_table['shared'] == 0) {
                echo "<br><br> <h2>Diese Liste ist Privat</h2> ";
                exit;
            } else {
                if ($row_table['shared'] == 3 && isset($_SESSION['userid'])) {
                    include("menu.php");
                } else {
                    echo "<p>Geteilter modus</p>";
                }
            }
        }
        ?>

        <?php


        $sql = "SELECT * FROM todos WHERE table_id = '$table_id' ORDER BY active DESC, id DESC";
        $result = mysqli_query($connect, $sql);

        echo "<h1>" . $row_table['name'] . "</h1>";

        if (!$result) {
            echo "<script> alert('Daten konnten nicht geladen Werden.'); </script>";
        }

        if (isset($_POST['submit'])) {
            $id_del = $_POST['id'];
            $del = "UPDATE todos SET active = '0' WHERE id = '$id_del'";
            $pdelete = mysqli_query($connect, $del);
            echo ("<meta http-equiv='refresh' content='0'>");
        }
        if (isset($_POST['submit_del'])) {
            $id_su_del = $_POST['id'];
            $del = "DELETE FROM todos WHERE id = '$id_su_del'";
            $pdelete = mysqli_query($connect, $del);
            echo ("<meta http-equiv='refresh' content='0'>");
        }
        if (isset($_POST['new_submit'])) {
            $new_product = $_POST['new_product'];
            $new_type = $_POST['type'];
            $create = "INSERT INTO todos (user_id, table_id, value, type) VALUES ('$id', '$table_id', '$new_product', '$new_type')";
            $pcreate = mysqli_query($connect, $create);
            echo ("<meta http-equiv='refresh' content='0'>");
        }

        while ($dsatz = mysqli_fetch_assoc($result)) {
            if ($dsatz['type'] == "note") {
                $message_untrimed = "<h2>" . $dsatz['value'] . "</h2>" . $dsatz['note'];
                $message = preg_replace("/\r|\n/", "", $message_untrimed);
                echo "<div alt='View Note' style='cursor:pointer;' onclick='createAlert(\"" . $message . "\")' class='one'>";
                echo $dsatz['value'];
                echo "   <span class='info'>Note</span>";
                echo "<a class='material-icons expand_button' href='note.php?note=" . $dsatz['id'] . "'>&#xe745</a>
    </form>";
                echo "<br></div>";
            } else {
                if ($dsatz['active'] == "1") {
                    echo "<div class='one'>
    <form action='' method='post'>";
                    echo $dsatz['value'];
                    echo "   <span class='info'>ToDo</span>";
                    echo "<input type='hidden' name='product' value='" . $dsatz['value'] . "'>
    <input type='hidden' name='id' value='" . $dsatz['id'] . "'>";
                    echo "<input class='material-icons' id='del' name='submit' type='submit' value='&#xe876;'>
    </form>";
                    echo "<br></div>";
                } else {
                    echo "<div id='deleted' class='one'>
    <form action='' method='post'>";
                    echo $dsatz['value'];
                    echo "<input type='hidden' name='product' value='" . $dsatz['value'] . "'>
    <input type='hidden' name='id' value='" . $dsatz['id'] . "'>";
                    echo "<input class='material-icons' id='del' name='submit_del' type='submit' value='&#xe5cd;'>
    </form>";
                    echo "<br></div>";
                }
            }
        }
        ?>
    </div>

    <span class="share_button material-icons" onclick="openShare()">&#xe80d;</span>

    <form id="add_form" action="" method="post">
        <select class="selector" type="select" name="type">
            <option value="todo">ToDo </option>
            <option value="note">Note </option>
        </select> <br>
        <input type="text" required id="new_product" name="new_product" placeholder="Text eingeben"> <br>
        <input id="new_submit" type="submit" value="Speichern" name="new_submit">
    </form>

    </div>
</body>
<?php include("footer.php"); ?>


</html>