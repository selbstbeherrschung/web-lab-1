<?php

// x , y , r , shot or miss , start , time

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

function writePrevTable()
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

    if(!count($_SESSION['history'])){
        return;
    }

    $prev_shots = $_SESSION['history'];
    foreach ($prev_shots as $shot) {
        write_shot($shot);
    }
}


session_start();

if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = array();
}

$XGet = (int)htmlspecialchars($_GET['answerX']);
$YGet = (double)htmlspecialchars($_GET['answerY']);
$RGet = (float)htmlspecialchars($_GET['answerR']);

date_default_timezone_set("Europe/Moscow");
$start = date("d.m.Y;H:i:s:u");
$time = microtime(true);

writePrevTable();

if (isset($_GET['answerX']) and isset($_GET['answerY']) and isset($_GET['answerR'])) {
    if ($XGet >= -4 and $XGet <= 4 and $YGet >= -5 and $YGet <= 3 and $RGet >= 1 and $RGet <= 3) {

        $shot = make_shot($XGet, $YGet, $RGet);
        $time = microtime(true) - $time;
        $shot .= $start . ' ' . number_format($time, 10);
        write_shot($shot);

        array_push($_SESSION['history'], $shot);
        echo '</tbody></table>';
    } else {
        echo '<tr><td colspan="6"><div class="warning">' . "Wrong vars response: X=" . $XGet . " Y=" . $YGet . " R=" . $RGet . '</div></td></tr>';
        echo '</table>';
    }
} else {
    echo '<tr><td colspan="6"><div class="warning">' . "Variables doesn't set: X=" . $XGet . " Y=" . $YGet . " R=" . $RGet . ' '. $_GET . $_POST. '</div></td></tr>';
    echo '</table>';
}
?>