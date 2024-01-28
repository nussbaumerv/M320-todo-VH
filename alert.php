<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .alertContainer {
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

        .alertMessage {
            border: solid;
            border-color: rgb(156, 156, 156);
            border-width: 2px;
            background-color: white;
            width: 80%;
            max-height: 80%;
            padding: 20px;
            overflow-y:scroll; 
            overflow-x:hidden; 
            position: absolute;
            z-index: 1;
            top: 50%;
            left: 50%;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.4), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            transform: translate(-50%, -50%);
        }

        .alertContent {
            padding: 30px 30px;
        }

        .closeAlert {
            color: #aaaaaa;
            font-size: 28px;
            padding: 1px 10px;
            font-weight: bold;
            position: fixed;
            right:10px;
        }

        .closeAlert:hover,
        .closeAlert:focus {
            color: grey;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
    <script>
        function exit() {
            document.getElementById("alertContainer").style.display = "none";
            reaction();
        }


        function createAlert(message) {
            document.getElementById("alertText").innerHTML = message;
            document.getElementById("alertContainer").style.display = "block";
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById("premContainer") && document.getElementById("premContainer").style.display == "block") {
                exitPremission();
            }
            if (event.target == document.getElementById("alertContainer") && document.getElementById("alertContainer").style.display == "block") {
                exit();

            }
        }

    </script>
</head>

<body>
    <div class="alertContainer" id="alertContainer">
        <div class="alertMessage" id="alertMessage">
            <span onclick="exit()" class="closeAlert">&times;</span>
            <div class="alertContent" id="alertContent">
                <span class="alertText" id="alertText">Message?</span>
            </div>
        </div>
    </div>
</body>

</html>