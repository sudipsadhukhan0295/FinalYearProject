<?php

include_once './connect.php';
include_once './WeightCheck.php';
include_once './Function.php';
$result = mysqli_query($link, "SELECT age,sex,BP,smokes,cholestrol,weight,fasting,family_history from patient");
$stroke = array();
$factors = 8;
$c1 = $c2 = 0;
$x1 = $x2 = 0;
$counter = $counter1 = 0;
$cluster1 = array();
$cluster2 = array();
$n = mysqli_num_rows($result);
while ($row = mysqli_fetch_array($result)) {
    $stroke[] = $row;
}
$result = mysqli_query($link, "SELECT height from patient");
$height = [];
while ($row = mysqli_fetch_array($result)) {
    $height[] = $row;
}
$result = mysqli_query($link, "SELECT name from patient");
$name = [];
while ($row = mysqli_fetch_array($result)) {
    $name[] = $row;
}
for ($i = 0; $i < $n; $i++) {
    if ($stroke[$i][0] > 55) {//Checks age
        $stroke[$i][0] = 1;
    } else {
        $stroke[$i][0] = 0;
    }
    if ($stroke[$i][2] > 120) {//checks blood pressure
        $stroke[$i][2] = 1;
    } else {
        $stroke[$i][2] = 0;
    }
    if ($stroke[$i][4] > 200) {//checks cholestrol
        $stroke[$i][4] = 1;
    } else {
        $stroke[$i][4] = 0;
    }
    $weight = check_weight($stroke, $n, $height, $i); //checks weight
    $stroke[$i][5] = $weight;
    if ($stroke[$i][6] > 126) {//checks diabetes(Fasting only)
        $stroke[$i][6] = 1;
    } else {
        $stroke[$i][6] = 0;
    }
}
echo "stroke array";
echo "<br>";
print_r($stroke);
echo "<br/>";
for ($i = 0; $i < $n; $i++) {
    for ($j = 0; $j < $factors; $j++) {
        print_r($stroke[$i][$j]);
    }
    echo '<br/>';
}

for ($i = 0; $i < $n; $i++) {//divides the table into 2 cluster tables
    if ($i % 2 != 0) {

        for ($k = 0; $k < $factors; $k++)
            $cluster1[$c1][$k] = $stroke[$i][$k];
        $c1++;
    } else {
        for ($j = 0; $j < $factors; $j++)
            $cluster2[$c2][$j] = $stroke[$i][$j];
        $c2++;
    }
}

echo"The Cluster-1 Table is:";
echo "<br>";
for ($i = 0; $i < $c1; $i++) {
    for ($j = 0; $j < $factors; $j++)
        print_r($cluster1[$i][$j]);
    echo '<br>';
}
print_r("The Cluster-2 Table is:");
echo "<br>";
for ($i = 0; $i < $c2; $i++) {
    for ($j = 0; $j < $factors; $j++)
        print_r($cluster2[$i][$j]);
    echo '<br>';
}
echo "<br>";
$SID1 = cal_sid($cluster1, $c1, $factors); //sid function for cluster-1
$SID2 = cal_sid($cluster2, $c2, $factors); //sid function for cluster-2

echo "Enter minimum support: 1";
$min_sup = 1;
echo "<br>";
echo "The SID for cluster-1:";
for ($i = 0; $i < $factors; $i++) {
    echo $SID1[$i];
}
echo "<br>";
echo "The SID for cluster-2:";
for ($i = 0; $i < $factors; $i++) {
    echo $SID2[$i];
}
echo "<br>";

$SN1 = cal_sn($cluster1, $c1, $factors); //calculates SN for cluster-1
$SN2 = cal_sn($cluster2, $c2, $factors); //calculates SN for cluster-2
echo "The SN for cluster-1:";
for ($i = 0; $i < $factors; $i++) {
    echo $SN1[$i];
}
echo "<br>";
echo "The SN for cluster-2:";
for ($i = 0; $i < $factors; $i++) {
    echo $SN2[$i];
}
echo "<br>";
for ($i = 0; $i < $factors; $i++) {//checks for minimum support
    if ($SID1[$i] < $min_sup) {
        $SID1[$i] = 0;
        $SN1[$i] = 0;
    }
    if ($SID2[$i] < $min_sup) {
        $SID2[$i] = 0;
        $SN2[$i] = 0;
    }
}

echo "The frequent-1 item set from Cluster-1:";
for ($i = 0; $i < $factors; $i++) {
    if ($SID1[$i] >= $min_sup)
        echo $i + 1;
}
echo "<br>";
echo "The frequent-1 item set from Cluster-2";
for ($i = 0; $i < $factors; $i++) {
    if ($SID2[$i] >= $min_sup)
        echo $i + 1;
}
echo "<br>";

$and1 = anding($SN1, $factors);
$and2 = anding($SN2, $factors);
echo "<br>";
for ($i = 0; $i < $factors; $i++) {
    for ($j = 0; $j < $factors; $j++)
        echo $and1[$i][$j];
    echo "<br>";
}
echo "<br>";
for ($i = 0; $i < $factors; $i++) {
    for ($j = 0; $j < $factors; $j++)
        echo $and2[$i][$j];
    echo "<br>";
}

for ($i = 0; $i < $factors; $i++) {
    for ($j = 0; $j < $factors; $j++) {
        $x1 = decToBinary($and1[$i][$j], $min_sup);
        if ($x1 < $min_sup)
            $and1[$i][$j] = 0;
        $x2 = decToBinary($and2[$i][$j], $min_sup);
        if ($x2 < $min_sup)
            $and2[$i][$j] = 0;
    }
}
echo "<br>";
for ($i = 0; $i < $factors; $i++) {
    for ($j = 0; $j < $factors; $j++)
        echo $and1[$i][$j];
    echo "<br>";
}
echo "<br>";
for ($i = 0; $i < $factors; $i++) {
    for ($j = 0; $j < $factors; $j++)
        echo $and2[$i][$j];
    echo "<br>";
}
echo "The frequent-2 item set from Cluster-1:";
echo "<br>";
for ($i = 0; $i < $factors; $i++) {
    for ($j = 0; $j < $factors; $j++) {
        if ($and1[$i][$j] != 0 && $i < $j) {
            echo "(";
            echo $i + 1;
            echo ',';
            echo $j + 1;
            echo ")";
            $answer=[$i,$j];
        }
    }
}
echo "<br>";
echo "The frequent-2 item set from Cluster-2:";
echo "<br>";
for ($i = 0; $i < $factors; $i++) {
    for ($j = 0; $j < $factors; $j++) {
        if ($and2[$i][$j] != 0 && $i < $j) {
            echo "(";
            echo $i + 1;
            echo ',';
            echo $j + 1;
            echo ")";
            $answer=[$i,$j];
        }
    }
}
echo "<br>";
echo"The frequent-3 item set from Cluster-1:";
for ($i = 0; $i < $factors; $i++) {
    for ($j = 0; $j < $factors; $j++) {
        for ($k = 0; $k < $factors; $k++) {
            if ($and1[$i][$j] != 0 && $and1[$j][$k] != 0 && $i < $j && $j < $k) {
                echo "(";
                echo $i + 1;
                echo $j + 1;
                echo $k + 1;
                echo ")";
                $answer=[$i,$j,$k];
                $counter++;
            }
        }
    }
}
echo "<br>";
if ($counter == 0)
    echo "No frequent-3 item set in cluster-1";
echo "The frequent-3 item set from Cluster-2:";
echo "<br>";
for ($i = 0; $i < $factors; $i++) {
    for ($j = 0; $j < $factors; $j++) {
        for ($k = 0; $k < $factors; $k++) {
            if ($and2[$i][$j] != 0 && $and2[$j][$k] != 0 && $i < $j && $j < $k) {
                echo "(";
                echo $i + 1;
                echo ",";
                echo $j + 1;
                echo ",";
                echo $k + 1;
                echo ")";
                $answer=[$i,$j,$k];
                $counter1++;
            }
        }
    }
}
echo "<br>";
if ($counter1 == 0)
    echo "No frequent-3 item set in cluster-2";
if ($counter > 0) {
    $counter = 0;
    echo "The frequent-4 item set from Cluster-1:";
    echo "<br>";
    for ($i = 0; $i < $factors; $i++) {
        for ($j = 0; $j < $factors; $j++) {
            for ($k = 0; $k < $factors; $k++) {
                for ($l = 0; $l < $factors; $l++) {
                    if ($and1[$i][$j] != 0 && $and1[$j][$k] != 0 && $and1[$k][$l] != 0 && $i < $j && $j < $k && $k < $l) {
                        echo "(";
                        echo $i + 1;
                        echo ",";
                        echo $j + 1;
                        echo ",";
                        echo $k + 1;
                        echo ",";
                        echo $l + 1;
                        echo ")";
$answer=[$i,$j,$k,$l];
                        $counter++;
                    }
                }
            }
        }
    }
    if ($counter == 0)
        echo "No frequent-4 item set in cluster-1";
}
echo "<br>";
if ($counter1 > 0) {
    $counter1 = 0;
    echo "The frequent-4 item set from Cluster-2:\n";
    echo "<br>";
    for ($i = 0; $i < $factors; $i++) {
        for ($j = 0; $j < $factors; $j++) {
            for ($k = 0; $k < $factors; $k++) {
                for ($l = 0; $l < $factors; $l++) {
                    if ($and2[$i][$j] != 0 && $and2[$j][$k] != 0 && $and2[$k][$l] != 0 && $i < $j && $j < $k && $k < $l) {
                        echo "(";
                        echo $i + 1;
                        echo ",";
                        echo $j + 1;
                        echo ",";
                        echo $k + 1;
                        echo ",";
                        echo $l + 1;
                        echo ")";
                        $counter1++;
                        $answer=[$i,$j,$k,$l];
                    }
                }
            }
        }
    }
    if ($counter1 == 0)
        echo "No frequent-4 item set in cluster-2";
}
echo "<br>";
if ($counter > 0) {
    $counter = 0;
    echo "The frequent-5 item set from Cluster-1:";
    echo "<br>";
    for ($i = 0; $i < $factors; $i++) {
        for ($j = 0; $j < $factors; $j++) {
            for ($k = 0; $k < $factors; $k++) {
                for ($l = 0; $l < $factors; $l++) {
                    for ($m = 0; $m < $factors; $m++) {
                        if ($and1[$i][$j] != 0 && $and1[$j][$k] != 0 && $and1[$k][$l] != 0 && $and1[$l][$m] != 0 && $i < $j && $j < $k && $k < $l && $l < $m) {
                            echo "(";
                            echo $i + 1;
                            echo ",";
                            echo $j + 1;
                            echo ",";
                            echo $k + 1;
                            echo ",";
                            echo $l + 1;
                            echo ",";
                            echo $m + 1;
                            echo ")";
                            $answer=[$i,$j,$k,$l,$m];
                            $counter++;
                        }
                    }
                }
            }
        }
    }
    if ($counter == 0)
        echo "No frequent-5 item set in cluster-1";
}
echo "<br>";
if ($counter1 > 0) {
    $counter1 = 0;
    echo "The frequent-5 item set from Cluster-2:";
    echo "<br>";
    for ($i = 0; $i < $factors; $i++) {
        for ($j = 0; $j < $factors; $j++) {
            for ($k = 0; $k < $factors; $k++) {
                for ($l = 0; $l < $factors; $l++) {
                    for ($m = 0; $m < $factors; $m++) {
                        if ($and2[$i][$j] != 0 && $and2[$j][$k] != 0 && $and2[$k][$l] != 0 && $and2[$l][$m] && $i < $j && $j < $k && $k < $l && $l < $m) {
                            echo "(";
                            echo $i + 1;
                            echo ",";
                            echo $j + 1;
                            echo ",";
                            echo $k + 1;
                            echo ",";
                            echo $l + 1;
                            echo ",";
                            echo $m + 1;
                            echo ")";
                            $counter1++;
                            $answer=[$i,$j,$k,$l,$m];
                        }
                    }
                }
            }
        }
    }
    if ($counter1 == 0)
        echo "No frequent-5 item set in cluster-2";
}
echo "<br>";
if ($counter > 0) {
    $counter = 0;
    echo "The frequent-6 item set from Cluster-1:";
    echo "<br>";
    for ($i = 0; $i < $factors; $i++) {
        for ($j = 0; $j < $factors; $j++) {
            for ($k = 0; $k < $factors; $k++) {
                for ($l = 0; $l < $factors; $l++) {
                    for ($m = 0; $m < $factors; $m++) {
                        for ($o = 0; $o < $factors; $o++) {
                            if ($and1[$i][$j] != 0 && $and1[$j][$k] != 0 && $and1[$k][$l] != 0 && $and1[$l][$m] != 0 && $and1[$m][$o] != 0 && $i < $j && $j < $k && $k < $l && $l < $m && $m < $o) {
                                echo "(";
                                echo $i + 1;
                                echo ",";
                                echo $j + 1;
                                echo ",";
                                echo $k + 1;
                                echo ",";
                                echo $l + 1;
                                echo ",";
                                echo $m + 1;
                                echo ",";
                                echo $o + 1;
                                echo ")";
                                $counter++;
                                $answer=[$i,$j,$k,$l,$m,$o];
                            }
                        }
                    }
                }
            }
        }
    }
    if ($counter == 0)
        echo "No frequent-6 item set in cluster-1";
}
echo "<br>";
if ($counter1 > 0) {
    $counter1 = 0;
    echo "The frequent-6 item set from Cluster-2:";
    echo "<br>";
    for ($i = 0; $i < $factors; $i++) {
        for ($j = 0; $j < $factors; $j++) {
            for ($k = 0; $k < $factors; $k++) {
                for ($l = 0; $l < $factors; $l++) {
                    for ($m = 0; $m < $factors; $m++) {
                        for ($o = 0; $o < $factors; $o++) {
                            if ($and2[$i][$j] != 0 && $and2[$j][$k] != 0 && $and2[$k][$l] != 0 && $and2[$l][$m] != 0 && $and2[$m][$o] != 0 && $i < $j && $j < $k && $k < $l && $l < $m && $m < $o) {
                                echo "(";
                                echo $i + 1;
                                echo ",";
                                echo $j + 1;
                                echo ",";
                                echo $k + 1;
                                echo ",";
                                echo $l + 1;
                                echo ",";
                                echo $m + 1;
                                echo ",";
                                echo $o + 1;
                                echo ")";
                                $counter1++;
                                $answer=[$i,$j,$k,$l,$m,$o];
                            }
                        }
                    }
                }
            }
        }
    }
    if ($counter1 == 0)
        echo "No frequent-6 item set in cluster-2";
}
echo "<br>";
if ($counter > 0) {
    $counter = 0;
    echo "The frequent-7 item set from Cluster-1:";
    echo "<br>";
    for ($i = 0; $i < $factors; $i++) {
        for ($j = 0; $j < $factors; $j++) {
            for ($k = 0; $k < $factors; $k++) {
                for ($l = 0; $l < $factors; $l++) {
                    for ($m = 0; $m < $factors; $m++) {
                        for ($o = 0; $o < $factors; $o++) {
                            for ($p = 0; $p < $factors; $p++) {
                                if ($and1[$i][$j] != 0 && $and1[$j][$k] != 0 && $and1[$k][$l] != 0 && $and1[$l][$m] != 0 && $and1[$m][$o] != 0 && $and1[$o][$p] != 0 && $i < $j && $j < $k && $k < $l && $l < $m && $m < $o && $o < $p) {
                                    echo "(";
                                    echo $i + 1;
                                    echo ",";
                                    echo $j + 1;
                                    echo ",";
                                    echo $k + 1;
                                    echo ",";
                                    echo $l + 1;
                                    echo ",";
                                    echo $m + 1;
                                    echo ",";
                                    echo $o + 1;
                                    echo ",";
                                    echo $p + 1;
                                    echo ")";
                                    $counter++;
                                    $answer=[$i,$j,$k,$l,$m,$o,$p];
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    if ($counter == 0)
        echo "No frequent-7 item set in cluster-1";
}
echo "<br>";
if ($counter1 > 0) {
    $counter1 = 0;
    echo "The frequent-7 item set from Cluster-2:";
    echo "<br>";
    for ($i = 0; $i < $factors; $i++) {
        for ($j = 0; $j < $factors; $j++) {
            for ($k = 0; $k < $factors; $k++) {
                for ($l = 0; $l < $factors; $l++) {
                    for ($m = 0; $m < $factors; $m++) {
                        for ($o = 0; $o < $factors; $o++) {
                            for ($p = 0; $p < $factors; $p++) {
                                if ($and2[$i][$j] != 0 && $and2[$j][$k] != 0 && $and2[$k][$l] != 0 && $and2[$l][$m] != 0 && $and2[$m][$o] != 0 && $and2[$o][$p] != 0 && $i < $j && $j < $k && $k < $l && $l < $m && $m < $o && $o < $p) {
                                    echo "(";
                                    echo $i + 1;
                                    echo ",";
                                    echo $j + 1;
                                    echo ",";
                                    echo $k + 1;
                                    echo ",";
                                    echo $l + 1;
                                    echo ",";
                                    echo $m + 1;
                                    echo ",";
                                    echo $o + 1;
                                    echo ",";
                                    echo $p + 1;
                                    echo ")";
                                    $counter1++;
                                    $answer=[$i,$j,$k,$l,$m,$o,$p];
                                }
                            }
                        }
                    }
                }
            }
        }
        
    }
    if ($counter1 == 0)
        echo "No frequent-7 item set in cluster-2";
}
echo "<br>";
if ($counter > 0) {
    $counter = 0;
    echo "The frequent-8 item set from Cluster-1:";
    echo "<br>";
    for ($i = 0; $i < $factors; $i++) {
        for ($j = 0; $j < $factors; $j++) {
            for ($k = 0; $k < $factors; $k++) {
                for ($l = 0; $l < $factors; $l++) {
                    for ($m = 0; $m < $factors; $m++) {
                        for ($o = 0; $o < $factors; $o++) {
                            for ($p = 0; $p < $factors; $p++) {
                                for ($q = 0; $q < $factors; $q++) {
                                    if ($and1[$i][$j] != 0 && $and1[$j][$k] != 0 && $and1[$k][$l] != 0 && $and1[$l][$m] != 0 && $and1[$m][$o] != 0 && $and1[$o][$p] != 0 && $and1[$p][$q] != 0 && $i < $j && $j < $k && $k < $l && $l < $m && $m < $o && $o < $p && $p < $q) {
                                        echo $i + 1;
                                        echo $j + 1;
                                        echo $k + 1;
                                        echo $l + 1;
                                        echo $m + 1;
                                        echo $o + 1;
                                        echo $p + 1;
                                        echo $q + 1;
                                        $counter++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    if ($counter == 0)
        echo"No frequent-8 item set in cluster-1";
}
echo "<br>";
if ($counter1 > 0) {
    $counter1 = 0;
    echo "The frequent-8 item set from Cluster-2:";
    echo "<br>";
    for ($i = 0; $i < $factors; $i++) {
        for ($j = 0; $j < $factors; $j++) {
            for ($k = 0; $k < $factors; $k++) {
                for ($l = 0; $l < $factors; $l++) {
                    for ($m = 0; $m < $factors; $m++) {
                        for ($o = 0; $o < $factors; $o++) {
                            for ($p = 0; $p < $factors; $p++) {
                                for ($q = 0; $q < $factors; $q++) {
                                    if ($and2[$i][$j] != 0 && $and2[$j][$k] != 0 && $and2[$k][$l] != 0 && $and2[$l][$m] != 0 && $and2[$m][$o] != 0 && $and2[$o][$p] != 0 && $and2[$p][$q] != 0 && $i < $j && $j < $k && $k < $l && $l < $m && $m < $o && $o < $p && $p < $q) {
                                        echo $i + 1;
                                        echo $j + 1;
                                        echo $k + 1;
                                        echo $l + 1;
                                        echo $m + 1;
                                        echo $o + 1;
                                        echo $p + 1;
                                        echo $q + 1;
                                        $counter1++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    if ($counter1 == 0)
        echo "No frequent-8 item set in cluster-2";
}
    echo '<br/>';
    $c=0;
for ($i = 0; $i < $n; $i++) {
    for ($j = 0; $j < sizeof($answer); $j++) {
        if($stroke[$i][$answer[$j]]==1){
            $c++;
        //print_r($answer[$j]);
        }
        if($c== sizeof($answer)){
            echo 'Patient with high chances of stroke : ';
            echo $name[$i][0];
        }
    }
    
    echo '<br/>';
}
