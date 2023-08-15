<?php
include('./config.php');
error_reporting(E_ERROR | E_PARSE);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="./style.css?v=<?php echo time(); ?>">
    <title>Talhacaba</title>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       
</head>

<body>
    <main>
        <section class="header">
            <h1>Talhacaba - FiveM Server Status</h1>
        </section>

        <section class="server-info" id="server-status"></section>

        <section class="online-players" id="player-cards"></section>
    </main>

    <script>
        $(document).ready(function() {
            $("#server-status").load("./includes/server-info.php");
            $("#player-cards").load("./includes/player-info.php");
            var intervalId = window.setInterval(function() {
                $("#server-status").load("./includes/server-info.php");
                $("#player-cards").load("./includes/player-info.php");
            }, <?php echo $updateFrequency;?>);
        });
    </script>

    <?php include_once('./footer.php');?>
</body>
</html>