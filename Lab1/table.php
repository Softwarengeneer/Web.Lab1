<?php
$start = microtime(true);

session_start();

if(!isset($_SESSION["requestsCount"])){
    $_SESSION["requestsCount"] = 0;
}

?>

<html>
<head>
    <meta charset="utf-8">
    <title>1 лабораторная работа</title>
    <link rel="stylesheet" href="css/result.css">
</head>
<body>
<table class="results">
    <tr class="header">
        <th>Координата X</th>
        <th>Координата Y</th>
        <th>Радиус</th>
        <th>Результат</th>
        <th>Текущее время</th>
        <th>Время работы скрипта</th>
    </tr>
    <?php

    function printTD($num){
        echo "<tr>\n<td>".$_SESSION["request".$num."x"]."</td>\n
                                <td>".$_SESSION["request".$num."y"]."</td>\n
                                <td>".$_SESSION["request".$num."r"]."</td>\n
                                <td>".$_SESSION["request".$num."res"]."</td>\n
                                <td>".$_SESSION["request".$num."date"]."</td>\n
                                <td>".$_SESSION["request".$num."runtime"]."</td>\n</tr>\n";
    }

    for($i = 0; $i < $_SESSION["requestsCount"]; $i++){
        printTD($i);
    }

    $radiox = htmlspecialchars($_GET["radiox"]);
    $radioy = htmlspecialchars($_GET["radioy"]);
    $radius = htmlspecialchars($_GET["radius"]);

    if($radiox == "-")
        $radiox = "-1";
    if($radioy == "-")
        $radioy = "-1";

    function isHit($x, $y, $r){
        return $x <= 0 && $y <= 0 && $y >= (-2) * ($x - $r/2) || $x >= 0 && $y >= 0 && $x <= $r && $y <= $r
        || $x <= 0 && $y >= 0 && $x**2 + $y**2 <= $r**2 ? "YES" : "NO";
    }

    $reqName = "request".$_SESSION["requestsCount"];

    date_default_timezone_set("Europe/Moscow");

    $valid = is_numeric($radiox) && is_numeric($radioy) && is_numeric($radius) && $radiox >= -5
        && $radiox <= 3 && $radioy >= -3 && $radioy <= 3 && filter_var($radius,FILTER_VALIDATE_INT) !== FALSE
        && $radius >= 1 && $radius <= 5;

    $_SESSION[$reqName."x"] = $valid ? $radiox : "Error";
    $_SESSION[$reqName."y"] = $valid ? $radioy : "Error";
    $_SESSION[$reqName."r"] = $valid ? $radius : "Error";
    $_SESSION[$reqName."res"] = $valid ? isHit($radiox, $radioy, $radius) : "Error";
    $_SESSION[$reqName."date"] = date('m/d/Y h:i:s a', time());
    $_SESSION[$reqName."runtime"] = round(microtime(true) - $start, 5);

    printTD($_SESSION["requestsCount"]);
    $_SESSION["requestsCount"]++;

    ?>
</table>
<table>
    <tr class="manageButtons">
        <td>
            <a onclick="window.open('main.html', '_self')">
                <button>Назад</button>
            </a>
        </td>
        <td>
            <form action="clearHistory.php" method="get">
                <button>Очистить сессионную историю</button>
            </form>
        </td>
    </tr>
</table>
<form>

</form>
</body>
</html>
