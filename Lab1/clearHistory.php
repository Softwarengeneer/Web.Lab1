<?php
ob_start();
session_start();
if(isset($_SESSION["requestsCount"])){
    for($i = 0; $i < $_SESSION["requestsCount"]; $i++){
        $reqName = "request".$i;
        unset($_SESSION[$reqName."x"]);
        unset($_SESSION[$reqName."y"]);
        unset($_SESSION[$reqName."r"]);
        unset($_SESSION[$reqName."res"]);
        unset($_SESSION[$reqName."date"]);
        unset($_SESSION[$reqName."runtime"]);
    }
    unset($_SESSION["requestsCount"]);
}
?>

<html>
<head>
    <meta http-equiv="refresh" content="0;url=main.html">
</head>
</html>