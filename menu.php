<?php
require("connect.php");
$id = $_SESSION['userid'];
$table_menu = "SELECT * FROM tables WHERE user_id = '$id' ORDER BY id DESC";
$result_table_menu = mysqli_query($connect, $table_menu);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <style>
    .sidenav {
      height: 100%;
      width: 0;
      position: fixed;
      z-index: 1;
      top: 0;
      left: 0;
      background-color: #8f8f8f;
      overflow-x: hidden;
      transition: 0.5s;
      padding-top: 60px;
      text-align: left;
      font-size: 25px;
      color: black;
    }

    .sidenav a {
      padding: 8px 8px 8px 32px;
      text-decoration: none;
      font-size: 25px;
      color:black;
      transition: transform .2s;
      display: block;
      transition: 0.3s;
    }

    .sidenav a:hover {
      color: #292828;
      transition: transform .2s;
      transition: color .2s;
    }

    .sidenav .closebtn {
      position: absolute;
      top: 0;
      right: 25px;
      font-size: 36px;
      margin-left: 50px;
    }


    .zo {
      color: #545352;
      text-align: left;
      float: left;
      margin: 0;
      transition: color .2s;
      position: absolute;
      top: 30px;
      left: 30px;
      font-size: 40px;
      transition: font-size .2s;
      cursor: pointer
    }

    .zo:hover {
      color: grey;
      transition: color .2s;
      font-size: 41px;
      transition: font-size .2s;
    }

    #bottom {
      background-color: #8f8f8f;
      width: 100%;
      padding: 10px;
      color: #292828;
      position: absolute;
      left: 8px;
      bottom: 2.4em;
    }

    #top {
      overflow: scroll;
      overflow-x: hidden;
      height: 70vh;
    }


    @media only screen and (max-width: 600px) {
      .zo {
        left: 0px;
        top: 0px;
      }
    }
    
    .linksToDo {
        color:#292828 !important;
        font-size:20px !important;
    }
  </style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
</head>

<body>

  <div id="mySidenav" class="sidenav">
    <div id="top">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <a href="admin.php">Alle Listen anzeigen</a>
      <?php
      while ($row = mysqli_fetch_assoc($result_table_menu)) {
        if ($row['shared'] == 2) {
          echo "<a href='todo.php?id=" . $row['shared_id'] . " ' class='linksToDo'>" . $row['name'] . "</a>";
        } else {
          echo "<a href='todo.php?id=" . $row['id'] . "' class='linksToDo'>" . $row['name'] . "</a>";
        }
      }
      ?>
    </div>
    <br><br><br><br>

    <div id="bottom">
      <a href="logout.php">Logout</a>
    </div>
  </div>

  <div class="zo">
    <span class="navib" ondblclick="rb()" onclick="openNav()"> &#9776; </span>
  </div>

  <script>
    function openNav() {
      if (window.innerWidth < 450) {
        document.getElementById("mySidenav").style.width = "100vw";


      } else {
        document.getElementById("mySidenav").style.width = "350px";
        document.getElementById("main").style.marginLeft = "350px";
        document.body.style.backgroundColor = "black";
        document.getElementById("mySidenav").style.textAlign = "left";
      }
    }

    function closeNav() {
      document.getElementById("mySidenav").style.width = "0px";
      document.getElementById("main").style.marginLeft = "0";
      document.body.style.backgroundColor = "black";
    }
  </script>



</body>

</html>