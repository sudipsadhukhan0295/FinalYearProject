<?php

include_once './WeightCheck.php';

function check_weight($stroke, $n, $height, $i) {

    $w = $stroke[$i][5];
    $h = $height[$i];
    if ($stroke[$i][1] == 1) {
        $s = man_weight_check($h, $w);
        echo $s;
        return man_weight_check($h, $w);
    } else {
        $s = woman_weight_check($h, $w);
        echo $s;
        return woman_weight_check($h, $w);
    }
}

function cal_sn($cluster, $x, $SN, $factors) {
    $sum = $c = 0;
    for ($i = 0; $i < $factors; $i++) {
        for ($j = $x - 1; $j >= 0; $j--) {
            $sum = $sum + $cluster[$j][$i] * pow(2, $c++);
        }
        $c = 0;
        $SN[$i] = $sum;
        $sum = 0;
    }
}

function cal_sid($cluster, $x, $SID, $factors) {
    $count = 0;
    for ($i = 0; $i < $factors; $i++) {
        for ($j = 0; $j < $x; $j++) {
            if ($cluster[$j][$i] == 1) {
                $count++;
            }
        }
        $SID[$i] = $count;

        $count = 0;
    }
}

function anding($SN, $andd, $factors) {

    for ($i = 0; $i < $factors; $i++) {
        for ($j = 0; $j < $factors; $j++) {
            if ($SN[$i] != 0 && $SN[$j] != 0 && $i != $j) {
                $andd[$i][$j] = $SN[$i] & $SN[$j];
            } else
                $andd[$i][$j] = 0;
        }
    }
}

function decToBinary($n, $min_sup) {

    $i = $count = 0;
    $binaryNum = array();
    while ($n > 0) {
        $binaryNum[i] = n % 2;
        $n = $n / 2;
        $i++;
    }
    for ($j = 0; $j < $i; $j++) {
        if ($binaryNum[j] == 1)
            $count++;
    }
    return $count;
}
