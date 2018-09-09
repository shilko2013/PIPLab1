<?php
define("START_TIME",microtime(true));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Лаба 1</title>
    <meta charset="utf-8">
    <style>
        body {
            background: #5FC0CE;
        }

        header {
            font-size: medium;
            color: #FFAE00;
            text-shadow: 1px 1px 2px #FF1300;
        }

        header > table {
            background-color: #03899C;
            width: 100%;
            line-height: 0;
            min-width: 450px;
        }

        table.rounded-corners {
            border-radius: 50px;
            border: 3px solid #03799D;
        }

        header h1 {
            text-align: center
        }

        article div.error-div {
            text-align: center;
            color: #dd0c00;
            text-shadow: 1px 1px 2px #FFAE00;
            font-size: larger;
        }

        #back-page-button {
            height: 60px;
            width: 200px;
            border-radius: 15px;
            border: 3px solid #03799D;
            background-color: #03899C;
            text-shadow: 1px 1px 2px #FF1300;
            color: #FFAE00;
            padding: 0 2% 0 2%;
            outline: none;
            cursor: pointer;
        }

        #back-page-button:active {
            background-color: #5FC0CE;
        }

        article table {
            text-align: center;
            width: 100%;
        }

        table.article-table {
            border-collapse: collapse;
            border: 3px solid #03799D;
        }

        table.article-table td {
            border: 3px solid #03799D;
        }

        table.article-table th {
            border: 3px solid #03799D;
        }

        article span#yes {
            color: #009000;
            font-weight: bold;
        }

        article span#no {
            color: #aa2223;
            font-weight: bold;
        }

        span.sort-symbol {
            font-size: medium;
            cursor: pointer;
        }

    </style>
    <script src="sort_table.js" async></script>
</head>
<body>
<header>
    <table class="rounded-corners">
        <tr>
            <td><h1>Результаты проверки</h1></td>
        </tr>
    </table>
</header>
<article>
    <br>
    <table class="article-table" rules="all">
        <colgroup style="background-color: #21cfda">
            <col>
            <col>
            <col>
        </colgroup>
        <colgroup style="background-color: #51c7da">
            <col>
        </colgroup>
        <?php
        $x = str_replace(",", ".", $_REQUEST['param-x']);
        $y = str_replace(",", ".", $_REQUEST['param-y']);
        $r = str_replace(",", ".", $_REQUEST['param-r']);
        if (is_numeric($x) && is_numeric($y) && is_numeric($r) && floatval($r) >= 0) {
            ?>
            <thead onclick="sort(event);">
            <tr>
                <th>X <span class="sort-symbol">⮃</span></th>
                <th>Y <span class="sort-symbol">⮃</span></th>
                <th>R <span class="sort-symbol">⮃</span></th>
                <th data-type="reverse">Попадание <span class="sort-symbol">⮃</span></th>
            </tr>
            </thead>
        <?php
            $file = fopen("data.txt",'a');
            $tmpString = round($x,16)." ".round($y,16)." ".round($r,16)." ".($x >= 0 && $x <= $r && $y <= $r/2 && $y >= 0
                || $x <= 0 && $y >= 0 && $y <= $x + $r
                || $x <= 0 && $y <= 0 && $y*$y <= $r*$r - $x*$x
                ? 'y' : 'n')."\n";
            fwrite($file, $tmpString);
            $file = fopen("data.txt",'r');
            while (!feof($file)) {
                $string = fgets($file);
                $array = preg_split("/\s/", $string);
                if ($array[3]) {
                    ?>
                    <tr>
                        <td><?php echo $array[0]; ?></td>
                        <td><?php echo $array[1]; ?></td>
                        <td><?php echo $array[2]; ?></td>
                        <td><?php if ($array[3] == 'y')
                                        echo '<span id="yes">да</span>';
                                    else
                                        echo '<span id="no">нет</span>'; ?>
                        </td>
                    </tr>
                    <?php
                }
            }
        ?>
    </table>
    <br>
    <table>
        <colgroup style="background-color: #36BBCE">
            <col>
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>Текущее время</th>
            <th>Время работы скрипта</th>
        </tr>
        </thead>
        <td id="time-td">
            <script>
                function setTime() {
                    document.getElementById("time-td").innerHTML = new Date().toLocaleTimeString();
                }
                setInterval(setTime,1000);
                setTime();
            </script>
        </td>
        <td>
            <?php printf("%.2f мкс", (microtime(true) - START_TIME)*1000000); ?>
        </td>
        <?php } else { ?>
            <tr>
                <td>
                    <br>
                    <div class="error-div">Введены неправильные данные!</div>
                    <br>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    echo '<div style="font-size: large">'
                        . 'x = ' . ($x ?: 'неизвестно') . '<br>'
                        . 'y = ' . ($y ?: 'неизвестно') . '<br>'
                        . 'r = ' . ($r ?: 'неизвестно')
                        . '</div>';
                    ?>
                    <br>
                </td>
            </tr>
        <?php } ?>
    </table>
    <br>
    <table>
        <tr>
            <td colspan="6">
                <form action="index.html">
                    <button id="back-page-button" type="submit">Вернуться на страницу ввода параметров</button>
                </form>
            </td>
        </tr>
    </table>
</article>
</body>
</html>