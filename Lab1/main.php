<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

$start = microtime(true);
session_start();

if (!isset($_SESSION['requests']) || !is_array($_SESSION['requests'])) {
    $_SESSION['requests'] = [];
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>PipTUT</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<script type="text/javascript">
    function validate(input){
        input.value = input.value.replace(/[^0-9,.-]/g,'').replace(/,/, ".");
        if(isNaN(input.value) && input.value !== "-")
            input.value = "";

        if(input === document.getElementsByName("radioy")[0] && input.value <= -5){
            input.value = -4.99999;
        } else if(input === document.getElementsByName("radioy")[0] && input.value >= 5){
            input.value = 4.99999;
        }

        if(input.value.length > 8){
            input.value = input.value.slice(0, -1);
        }
    }

    function verify() {
        const lbl = document.getElementById('enterr');
        if (!Array.prototype.some.call(document.querySelectorAll('input[type=checkbox]'), elem => elem.checked)) {
            lbl.style.fontWeight = 'bold';
            lbl.style.color = 'red';
            alert('А поч не ввел радиус?');
            event.preventDefault();
        } else {
            lbl.style.fontWeight = 'inherit';
            lbl.style.color = 'inherit';
        }
    }
</script>
<div id="container">
    <div id="header">
        <h2>Лабораторная работа №1 по Web-Программированию</h2>
        <h3>Выполнил: Федоров Никита, Группа Р3232, Вариант 2820</h3>
    </div>



    <div id="sidebar">
        <h2>КартинОчка</h2>

            <tr>
                <td align="left" width="30%" id="image">
                    <img class="area" title="Areas" width="30%" src="picture.jpg"/>

                </td>
            </tr>

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
            if (isset($_GET["radiox"]) && isset($_GET["radioy"]) && isset($_GET["radius"])) {
                $radiox = htmlspecialchars($_GET["radiox"]);
                $radioy = htmlspecialchars($_GET["radioy"]);
                $radius = htmlspecialchars($_GET["radius"]);

                function isHit($x, $y, $r) {
                    return $x <= 0 && $y <= 0 && $y >= (-2) * ($x - $r / 2) || $x >= 0 && $y >= 0 && $x <= $r && $y <= $r
                    || $x <= 0 && $y >= 0 && $x ** 2 + $y ** 2 <= $r ** 2 ? "YES" : "NO";
                }

                date_default_timezone_set("Europe/Moscow");

                $validX = is_numeric($radiox) && $radiox >= -4 && $radiox <= 4;
                $validY = is_numeric($radioy) && $radioy > -5 && $radioy < 5 && filter_var($radiox, FILTER_VALIDATE_INT);
                $validR = is_numeric($radius) && filter_var($radius, FILTER_VALIDATE_INT) && $radius >= 1 && $radius <= 5;

                if ($validX && $validY && $validR) {
                    array_unshift($_SESSION['requests'], [
                        "y" => $radioy,
                        "x" => $radiox,
                        "r" => $radius,
                        "res" => isHit($radiox, $radioy, $radius),
                        "date" => date('m/d/Y h:i:s a', time()),
                        "runtime" => round(microtime(true) - $start, 5)
                    ]);
                } else {
                    if (!$validR) {
                        echo "НЕ ВАЛИДНЫЙ РАДИУССС!";
                    }

                    if (!$validY) {
                        echo("НЕ ВАЛИДНЫЙ ИГРИК!");
                    }

                    if (!$validX) {
                        echo("НЕ ВАЛИДНЫЙ ИКККС!");
                    }

                }
            }

            foreach ($_SESSION["requests"] as $request) {
                ?>
                <tr>
                    <td><?=$request["x"]?></td>
                    <td><?=$request["y"]?></td>
                    <td><?=$request["r"]?></td>
                    <td><?=$request["res"]?></td>
                    <td><?=$request["date"]?></td>
                    <td><?=$request["runtime"]?></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <table>
            <tr class="manageButtons">
                <td>
                    <form action="clearHistory.php" method="get">
                        <button>Очистить сессионную историю</button>
                    </form>
                </td>
            </tr>
        </table>

    </div>



    <div id="content">
        <h2>Вводи скорее кординаты</h2>
        <form action="main.php" method="get" onsubmit="verify()">

        <td align="right" width="70%">
            <h2 id="enterx">
                Выберите X:
            </h2>
            <label for="radiox-4">-4</label><input id="radiox-4" name="radiox" type="radio" value="-4" required/>
            <label for="radiox-3">-3</label><input id="radiox-3" name="radiox" type="radio" value="-3" required/>
            <label for="radiox-3">-2</label><input id="radiox-2" name="radiox" type="radio" value="-2" required/>
            <label for="radiox-1">-1</label><input id="radiox-1" name="radiox" type="radio" value="-1" required/>
            <label for="radiox0">0</label><input id="radiox0" name="radiox" type="radio" value="0" required/>
            <label for="radiox1">1</label><input id="radiox1" name="radiox" type="radio" value="1" required/>
            <label for="radiox2">2</label><input id="radiox2" name="radiox" type="radio" value="2" required/>
            <label for="radiox3">3</label><input id="radiox3" name="radiox" type="radio" value="3" required/>
            <label for="radiox4">4</label><input id="radiox4" name="radiox" type="radio" value="4" required/>
            <p id="messagex" ><br></p>

            <h2 id="entery">
                Введите Y в диапозоне (-5;5)
            </h2>
            <input type="text" id="radioy" name="radioy" oninput="validate(this)" required>
            <p id="messagey"><br></p>

            <h2 id="enterr">
                Выберите R:
            </h2>

            <label for="r1">1</label><input id="r1" name="radius" type="checkbox" value="1" />
            <label for="r2">2</label><input id="r2" name="radius" type="checkbox" value="2" />
            <label for="r3">3</label><input id="r3" name="radius" type="checkbox" value="3" />
            <label for="r4">4</label><input id="r4" name="radius" type="checkbox" value="4" />
            <label for="r5">5</label><input id="r5" name="radius" type="checkbox" value="5" />
            <p id="messager"><br></p>
            <p id="buttons">
                <button id="suputton" name="suputton" type="submit">Отправить...</button>
            </p>

            </form>
        </td>
    </div>



    <div id="footer">
        <h2>Возникли вопросы? Обратитесь к <a href="http://vk.com/werner_lw">разработчику.</a></h2>
    </div>
</div>
</body>
</html>
