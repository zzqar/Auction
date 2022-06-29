    <?php
    $ip = "localhost";
    $name = "root";
    $psw = "";
    $db = "auction";

    $mySQL = new mysqli($ip, $name, $psw, $db);

    if (!$mySQL){
        die('Error connect to DB  ');
    } 
    ?>
