<?php
require("connect.php");
$id = $_SESSION['userid'];
$table_menu = "SELECT * FROM tables WHERE user_id = '$id' ORDER BY id DESC";
$result_table_menu = mysqli_query($connect, $table_menu);

$table_shared = "SELECT * FROM tables WHERE id = '$table_id'";
$result_table_shared = mysqli_query($connect, $table_shared);
$row_table_shared = mysqli_fetch_assoc($result_table_shared);
$shared_before = $row_table_shared['shared'];

if (isset($_POST['submit_shared'])) {
    $shared = $_POST['shared'];

    if ($row_table_shared['shared_id'] != 0 && $shared == 1) {
        $sqlp = "UPDATE tables SET shared = '3', shared_id = '$table_id' WHERE id = '$table_id'";
    } else {
        $sqlp = "UPDATE tables SET shared = '$shared', shared_id = '$table_id' WHERE id = '$table_id'";
    }
    $resultp = mysqli_query($connect, $sqlp);

    echo ("<meta http-equiv='refresh' content='0'>");
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .shareContainer {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
        }

        .shareMessage {
            border: solid;
            border-color: rgb(156, 156, 156);
            border-width: 2px;
            background-color: white;
            width: 80%;
            padding: 20px;
            position: absolute;
            z-index: 1;
            top: 50%;
            left: 50%;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.4), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            transform: translate(-50%, -50%);
        }

        .shareContent {
            padding: 30px 30px;
        }

        .closeShare {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            padding: 1px 10px;
            font-weight: bold;
        }

        .closeShare:hover,
        .closeShare:focus {
            color: grey;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
    <script>
        function exitShare() {
            document.getElementById("shareContainer").style.display = "none";
            reaction();
        }


        function openShare() {
            document.getElementById("shareContainer").style.display = "block";
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById("premContainer") && document.getElementById("premContainer").style.display == "block") {
                exitPremission();
            }
            if (event.target == document.getElementById("shareContainer") && document.getElementById("shareContainer").style.display == "block") {
                exit();

            }
        }
    </script>
</head>

<body>
    <div class="shareContainer" id="shareContainer">
        <div class="shareMessage" id="shareMessage">
            <span onclick="exitShare()" class="closeShare">&times;</span>
            <div class="shareContent" id="shareContent">
                <div class="shareText" id="shareText">
                    <h2>Share</h2>
                    <?php
                    if ($shared_before == 0) {
                        echo '<form action="" method="post"><select id="selection" name="shared"> <option id="op" value="0">Privat</option>
          <option id="op" value="1">Öffentlich</option> </select><br><br>
          <input id="new_submit" name="submit_shared" type="submit" value="Speichern" style="position:relative;"></form>';
                    } else {
                        if ($row_table_shared['user_id'] != $id) {
                        } else {
                            echo '<form action="" method="post"><select id="selection" name="shared""> <option id="op" value="1">Öffentlich</option>
            <option id="op" value="0">Privat</option></select> <br> <br>
             <input id="new_submit" name="submit_shared" type="submit" value="Speichern" style="position:relative;"></form>
<br>
 URL: <a href="https://todo.valentin-nussbaumer.com/add.php?id=' . $table_id . '">https://todo.valentin-nussbaumer.com/add.php?id=' . $table_id . '</a>


             ';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>