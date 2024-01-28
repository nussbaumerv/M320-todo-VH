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

        .container{
        min-height:100%;
    }


        form {
            padding: 0px;
            margin: 0px;
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
    </style>
</head>

<body>
<div class="container">
    <br>
    <div id="list">
        <?php
        session_start();

        $note_id = $_GET['note'];
        if ($note_id == "") {
            header("Location: admin.php");
            exit;
        }

        require_once "connect.php";

        $id = $_SESSION['userid'];
        $password = $_SESSION['password'];

        $user = "SELECT * FROM users WHERE id = '$id'";

        $result_user = mysqli_query($connect, $user);

        $row_user = mysqli_fetch_assoc($result_user);

        if (!$result_user) {
            echo "<script> alert('Daten konnten nicht geladen Werden.'); </script>";
        }
        $pwd = $row_user['password'];

        $note_acces = "SELECT * FROM todos WHERE id = '$note_id'";
        $result_note_acces = mysqli_query($connect, $note_acces);
        $row_note_acces = mysqli_fetch_assoc($result_note_acces);

        $table_id = $row_note_acces['table_id'];

        $table_sql = "SELECT * FROM tables WHERE id = '$table_id'";

        $result_table = mysqli_query($connect, $table_sql);
        $row_table = mysqli_fetch_assoc($result_table);
        if ($row_table['user_id'] == $id) {
            if ($password != $pwd) {
                header("Location: login.php");
                exit;
            }
            include("menu.php");
        } else {
            if ($row_table['shared'] == 0) {
                header("Location: todo.php?id=" . $table_id);
                exit;
            } else {
                if ($row_table['shared'] == 3 && isset($_SESSION['userid'])) {
                    include("menu.php");
                } else {
                    echo "<p>Geteilter modus</p>";
                }
            }
        }

        
        $sql = "SELECT * FROM todos WHERE id = '$note_id' ORDER BY active DESC, id DESC";
        $result = mysqli_query($connect, $sql);
        $dsatz = mysqli_fetch_assoc($result);

        echo "<h1>" . $dsatz['value'] . "</h1>";

        if (!$result) {
            echo "<script> alert('Daten konnten nicht geladen Werden.'); </script>";
        }

        if (isset($_POST['submit_del'])) {
            header("Location: https://apple.com");
            $id_su_del = $_POST['id'];
            $del = "DELETE FROM todos WHERE id = '$id_su_del'";
            $pdelete = mysqli_query($connect, $del);

            echo '<script type="text/javascript">
            window.location.href=" todo.php?id=' . $table_id . '";
          </script>';
        }
        if (isset($_POST['new_submit'])) {
            $id_del = $dsatz['id'];
            $name = $_POST['new_product'];
            $note = $_POST['new_name'];

            $del = "UPDATE todos SET value = '$name', note = '$note'  WHERE id = '$id_del'";
            $pdelete = mysqli_query($connect, $del);

            echo '<script type="text/javascript">
            window.location.href=" todo.php?id=' . $table_id . '";
          </script>';
        }
        ?>
    </div>
    <form action="" method="post">
        <input type="text" required id="new_product" name="new_product" value="<?php echo $dsatz['value']; ?>" placeholder="Titel eingeben"> <br>
        <textarea required id="new_product"  name="new_name" placeholder="Notiz eingeben" rows="10"><?php echo $dsatz['note']; ?></textarea> <br>
        <input id="new_submit" type="submit" value="Speichern" name="new_submit">
    </form>

    <form action="" method='post'>
        <input type='hidden' name='id' value="<?php echo $dsatz['id']; ?>">
        <input id="new_submit" type="submit" value="Löschen" name="submit_del">
    </form>
    <br><br>
    </div>
   
</body>
<?php include("footer.php"); ?>


</html>