<?php

// x , y , r , shot or miss , start , time

//Проверка попадания
function make_shot($X, $Y, $R)
{
    $result = $X . ' ' . $Y . ' ' . $R . ' ';
    if ($X > 0) {
        if ($Y > 0) {
            $result .= 'NO' . ' ';
        } else {
            if ($X ^ 2 + $Y ^ 2 <= $R ^ 2) $result .= 'YES' . ' ';
            else $result .= 'NO' . ' ';
        }
    } else {
        if ($Y > 0) {
            if ($X * (-1) + $Y * 2 <= $R) $result .= 'YES' . ' ';
            else $result .= 'NO' . ' ';
        } else {
            if ($X * (-1) <= ($R / 2) and $Y * (-1) <= $R) $result .= 'YES' . ' ';
            else $result .= 'NO' . ' ';
        }
    }

    return $result;
}

//Строка таблицы одного выстрела
//csv для хранения и обработки записи
function write_shot($shot)
{
    $shot_elements = str_getcsv($shot, ' ');
    echo '<tr><td class="x-class chooseable">' . $shot_elements[0] . '</td>';
    echo '<td class="y-class chooseable">' . $shot_elements[1] . '</td>';
    echo '<td class="r-class chooseable">' . $shot_elements[2] . '</td>';
    echo '<td class="som-class chooseable">' . $shot_elements[3] . '</td>';
    echo '<td class="stt-class chooseable">' . $shot_elements[4] . '</td>';
    echo '<td class="sct-class chooseable">' . $shot_elements[5] . '</td></tr>';
}

//Создание таблицы сохраннёных выстрелов
function writePrevTable()
{
    writeHead();
    writeBody();
}

//Шапка таблицы результатов
function writeHead()
{
    echo '<table id="page-table-T" border="1">';
    echo '<thead><tr><th id="x-id" class="stickyTh">' . "X" . '</th>';
    echo '<th class="y-class stickyTh">' . "Y" . '</th>';
    echo '<th class="r-class stickyTh">' . "R" . '</th>';
    echo '<th class="som-class stickyTh">' . "Y/N" . '</th>';
    echo '<th class="stt-class stickyTh">' . "Start time" . '</th>';
    echo '<th class="sct-class stickyTh">' . "Script time" . '</th>';
    echo '</th></tr></thead>';
    echo '<tbody>';

}

//Тело таблицы результатов
function writeBody()
{
    if (!count($_SESSION['history'])) {
        return;
    }

    //Начинает с самого позднего, что позволяет выводить самые последние наверху
    //Повышает читаемость
    for ($i = count($_SESSION['history'])-1; $i > 0; $i--) {
        write_shot($_SESSION['history'][$i]);
    }
}

//Старт сесси, проверка сессии

session_start();

if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = array();
}

//Получение аргументов
$XGet = (int)htmlspecialchars($_GET['answerX']);
$YGet = (double)htmlspecialchars($_GET['answerY']);
$RGet = (float)htmlspecialchars($_GET['answerR']);

//"Якорь времени" и время начала
date_default_timezone_set("Europe/Moscow");
$start = date("d.m.Y;H:i:s:u");
$time = microtime(true);

//Валидация со стороны сервера
if (isset($_GET['answerX']) and isset($_GET['answerY']) and isset($_GET['answerR'])) {
    if ($XGet >= -4 and $XGet <= 4 and $YGet >= -5 and $YGet <= 3 and $RGet >= 1 and $RGet <= 3) {

        $shot = make_shot($XGet, $YGet, $RGet);                     //Выстрел и его результаты
        $time = microtime(true) - $time;
        $shot .= $start . ' ' . number_format($time, 10);   //Получение времени

        writeHead();

        write_shot($shot); //Запись текущего выстрела

        writeBody();

        array_push($_SESSION['history'], $shot);               //Сохранение
        echo '</tbody></table>';
    } else {
        writePrevTable();   //Случай выхода за пределы диапозонов
        echo '<tr><td colspan="6"><div class="warning">' . "Wrong vars response: X=" . $XGet . " Y=" . $YGet . " R=" . $RGet . '</div></td></tr>';
        echo '</table>';
    }
} else {
    writePrevTable();   //Случай не инициализации переменных
    echo '<tr><td colspan="6"><div class="warning">' . "Variables doesn't set: X=" . $XGet . " Y=" . $YGet . " R=" . $RGet . ' ' . $_GET . $_POST . '</div></td></tr>';
    echo '</table>';
}
?>
