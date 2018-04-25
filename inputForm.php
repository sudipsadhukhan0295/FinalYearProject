<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include_once './connect.php';
        include_once './header.php';
        if (isset($_POST['age'])) {
            $age = $_POST['age'];
            $sex = $_POST['sex'];
            $BP = $_POST['BP'];
            $smokes = $_POST['smokes'];
            $cholestrol = $_POST['cholestrol'];
            $weight = $_POST['weight'];
            $height = $_POST['height'];
            $fasting = $_POST['fasting'];
            $family_history = $_POST['fh'];
            $result = mysqli_query($link, "insert into patient (age,sex,BP,smokes,cholestrol,weight,fasting,family_history) values('$age','$sex','$BP','$smokes','$cholestrol','$weight','$fasting','$family_history')");
        }
        ?>
        <div class="container">
            <div class="form-group" >
                <form action="inputForm.php" method="post" class="form-inline my-2 my-lg-0"> 
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
                        <input class="form-control" type="text" name="smokes" id="smokes">
                    </label><br>
                    <label>Cholesterol
                        <input class="form-control" type="text" name="cholestrol" id="cholestrol">
                    </label><br>
                    <label>Weight
                        <input class="form-control" type="text" name="weight" id="weight">
                    </label><br>
                    <label>Height
                        <input class="form-control" type="text" name="height" id="height">
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
