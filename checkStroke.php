<?php

include_once './connect.php';
$result = mysqli_query($link, "SELECT age,sex,BP,smokes,cholestrol,weight,fasting,family_history from patient");
$stroke = array();
$factors = 8;
$n= mysqli_num_rows($result);


while ($row = mysqli_fetch_array($result)) {
    $stroke[] = $row;
}

for ($i = 0; $i < $n; $i++) {
    if ($stroke[$i][0] > 55)//Checks age
        $stroke[$i][0] = 1;
    else
        $stroke[$i][0] = 0;
    if ($stroke[$i][2] > 120)//checks blood pressure
        $stroke[$i][2] = 1;
    else
        $stroke[$i][2] = 0;
    if ($stroke[$i][4] > 200)//checks cholestrol
        $stroke[$i][4] = 1;
    else
        $stroke[$i][4] = 0;
    
    //weight = check_weight(stroke, n, height); //checks weight
    //$stroke[$i][5] = weight;
    if ($stroke[$i][6] > 126)//checks diabetes(Fasting only)
        $stroke[$i][6] = 1;
    else
    $stroke[$i][6] = 0;
}
    for($i = 0;$i <$n;$i++) {
        for($j = 0;$j < $factors;$j++)
        print_r($stroke[$i][$j]);
        echo '<br/>';
    }

?>