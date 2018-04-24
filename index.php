<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include_once './connect.php';
        if (isset($_POST['age'])) {
            $age = $_POST['age'];
            $sex = $_POST['sex'];
            $BP = $_POST['BP'];
            $smokes = $_POST['smokes'];
            $cholestrol = $_POST['cholestrol'];
            $weight = $_POST['weight'];
            $fasting = $_POST['fasting'];
            $family_history = $_POST['fh'];
            $result = mysqli_query($link, "insert into patient (age,sex,BP,smokes,cholestrol,weight,fasting,family_history) values('$age','$sex','$BP','$smokes','$cholestrol','$weight','$fasting','$family_history')");
        }
        ?>
        <div class="container">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <ul class="nav navbar-nav">
                        <li>
                            <a>Stroke Predictor</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="form-group" >
                <form action="index.php" method="post" class="form-inline my-2 my-lg-0"> 
                    <label>Age
                        <input class="form-control" type="text" name="age" id="age">
                    </label>
                    <br>
                    <label>Male
                        <input type="radio" name="sex" value="1" id="male">
                    </label>
                    <label>Female
                        <input type="radio" name="sex" value="0" id="female">
                    </label>
                    <br>
                    <label>BP
                        <input class="form-control" type="text" name="BP" id="BP">
                    </label><br>
                    <label>Smokes
                        <input class="form-control" type="text" name="smokes" id="Smokes">
                    </label><br>
                    <label>Cholesterol
                        <input class="form-control" type="text" name="cholestrol" id="Cholestrol">
                    </label><br>
                    <label>Weight
                        <input class="form-control" type="text" name="weight" id="Weight">
                    </label><br>
                    <label>Fasting
                        <input class="form-control" type="text" name="fasting" id="Fasting">
                    </label><br>
                    <label>Family History
                        <input class="form-control" type="text" name="fh" id="fh">
                    </label><br>
                    <input type="submit"  value="Save" name='Save'> 
                </form>
            </div>
        </div>
    </body>
</html>
