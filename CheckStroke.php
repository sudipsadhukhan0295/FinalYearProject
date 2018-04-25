<?php

include_once './connect.php';
include_once './WeightCheck.php';
include_once './Function.php';
$result = mysqli_query($link, "SELECT age,sex,BP,smokes,cholestrol,weight,fasting,family_history from patient");
$stroke = array();
$factors = 8;
$c1 = $c2 = 0;
$n = mysqli_num_rows($result);
while ($row = mysqli_fetch_array($result)) {
    $stroke[] = $row;
}
$result = mysqli_query($link, "SELECT height from patient");
$height = array();
while ($row = mysqli_fetch_array($result)) {
    $height[] = $row;
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
print_r($stroke);
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
for ($i = 0; $i < $c1; $i++) {
    for ($j = 0; $j < $factors; $j++)
        print_r($cluster1[$i][$j]);
    echo '<br>';
}
print_r("The Cluster-2 Table is:");
for ($i = 0; $i < $c2; $i++) {
    for ($j = 0; $j < $factors; $j++)
        print_r($cluster2[$i][$j]);
    echo '<br>';
}
