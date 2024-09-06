<?php
$crtTable = $_GET['table'];
$moves = explode(',', $crtTable);

if (verifyColumns($moves) == true or verifyRows($moves) == true or verifyDiagonals($moves) == true)
    echo 'X'; //'X' won
else {
    // find an empty spot for 'O'
    $poz = mt_rand(0, 8);
    while ($moves[$poz] != '')
        $poz = mt_rand(0, 8);
    $moves[$poz] = 'O';

    if (verifyColumns($moves) == false and verifyRows($moves) == false and verifyDiagonals($moves) == false) {
        echo $poz;
    } else {
        echo 'O' . $poz; // 'O' won
    }
}

function verifyColumns($moves)
{
    $complete = false;
    for ($column = 0; $column < 3; $column++) {
        $player_symbol = $moves[$column];
        if ($player_symbol == '') {
        } else {
            $complete = true;
            for ($idx = $column; $idx < 9 && $complete == true; $idx += 3) {
                if ($moves[$idx] != $player_symbol) {
                    $complete = false;
                }
            }
            if ($complete == true) //complete column found - game over
                return $player_symbol;
        }
    }
    return false;  // complete column not found
}

function verifyRows($moves)
{
    $complete = false;
    for ($row = 0; $row < 9; $row += 3) {
        $player_symbol = $moves[$row];
        if ($player_symbol == '') {
        } else {
            $complete = true;
            for ($idx = $row; $idx < $row + 3; $idx += 1) {
                if ($moves[$idx] != $player_symbol) {
                    $complete = false;
                    break;
                }
            }
            if ($complete == true) //complete row found - game over
                return $player_symbol;
        }
    }
    return false;  // complete row not found
}

function verifyDiagonals($moves)
{
    //main diagonal
    $complete = false;
    $diag = 0;
    $firstValue = $moves[$diag];
    if ($firstValue == '') {
    } else {
        $complete = true;
        for ($idx = $diag; $idx < 9; $idx += 4) {
            if ($moves[$idx] != $firstValue) {
                $complete = false;
                break;
            }
        }
        if ($complete == true)
            return $firstValue;
    }

    //secondary diagonal
    $diag = 2;
    $firstValue = $moves[$diag];
    if ($firstValue == '') {
    } else {
        $complete = true;
        for ($idx = $diag; $idx <= 6; $idx += 2) {
            if ($moves[$idx] != $firstValue) {
                $complete = false;
                break;
            }
        }
        if ($complete == true)
            return $firstValue;
    }

    if ($complete == false)
        return false;
}

?>