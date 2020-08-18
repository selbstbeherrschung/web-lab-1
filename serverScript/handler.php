<!DOCTYPE html PUBLIC "-//W3C//DTD html 4.01//EN"
        "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<head>
    <title>
        Lab 1
    </title>
    <link rel="icon" type="image/png" href="../resources/icon.png">
    <link href="../styles/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<table id="m-table" border="1">

    <tr>
        <td>
            <header>
                Rogachev Kirill Olegovich P3230 2621
            </header>
        </td>
    </tr>

    <tr>
        <td colspan="10">
            <div>
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
                    echo '<tr><td class="x-class">' . $shot_elements[0] . '</td>';
                    echo '<td class="y-class">' . $shot_elements[1] . '</td>';
                    echo '<td class="r-class">' . $shot_elements[2] . '</td>';
                    echo '<td class="som-class">' . $shot_elements[3] . '</td>';
                    echo '<td class="stt-class">' . $shot_elements[4] . '</td>';
                    echo '<td class="sct-class">' . $shot_elements[5] . '</td></tr>';
                }

                function writePrevTable()
                {
                    echo '<table id="page-table" border="1">';
                    echo '<tr><th id="x-id">' . "X" . '</th>';
                    echo '<th class="y-class">' . "Y" . '</th>';
                    echo '<th class="r-class">' . "R" . '</th>';
                    echo '<th class="som-class">' . "Y/N" . '</th>';
                    echo '<th class="stt-class">' . "Start time" . '</th>';
                    echo '<th class="sct-class">' . "Script time" . '</th>';
                    echo '<th width="20px"></th></tr>';
                    echo '<tr><td colspan="7"><div id="scroll-container"><table border="1">';
                    $prev_shots = file('shotTable.csv');
                    foreach ($prev_shots as $shot) {
                        write_shot($shot);
                    }
                }

                $XGet = htmlspecialchars($_GET['answerX']);
                $YGet = htmlspecialchars($_GET['answerY']);
                $RGet = htmlspecialchars($_GET['answerR']);

                $start = date("d.m.Y;H:i:s:u");
                $time = microtime(true);
                writePrevTable();

                if (isset($_GET['answerX']) and isset($_GET['answerY']) and isset($_GET['answerR'])) {
                    if ($XGet >= -4 and $XGet <= 4 and $YGet >= -5 and $YGet <= 3 and $RGet >= 1 and $RGet <= 3) {
                        $fp = fopen("shotTable.csv", "a");
                        $shot = make_shot($XGet, $YGet, $RGet);
                        $time = microtime(true) - $time;
                        $shot .= $start . ' ' . number_format($time, 10);
                        write_shot($shot);
                        $check = fwrite($fp, $shot . "\r\n");
                        fclose($fp);
                        echo '</table></div></td></tr>';
                        if (!$check) echo '<tr><td colspan="6"><div class="warning">' . "Error not write" . '</div></td></tr>';
                        echo '</table>';
                    } else {
                        echo '</table></div></td></tr>';
                        echo '<tr><td colspan="6"><div class="warning">' . "Wrong vars response: X=" . $XGet . " Y=" . $YGet . " R=" . $RGet . '</div></td></tr>';
                        echo '</table>';
                    }
                } else {
                    echo '</table></div></td></tr>';
                    echo '<tr><td colspan="6"><div class="warning">' . "Variables doesn't set: X=" . $XGet . " Y=" . $YGet . " R=" . $RGet . '</div></td></tr>';
                    echo '</table>';
                }
                ?>
            </div>
        </td>
    </tr>

</table>
</body>
</HTML>