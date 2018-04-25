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
            $name=$_POST['name'];
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
                <form action="inputForm.php" method="post" >
                    <label>Patient's Name:</label><br/>
                    <input type="text"  class="form-control" name="name" id="name" placeholder="Please Enter Patient name..." required><br>
                    <label>Age:</label><br/>
                    <input type="text"  class="form-control" name="age" id="age" placeholder="Please Enter Age..." required><br>
                    <label>Gender:</label><br>
                    <label><input type="radio" name="sex" value="1" id="male">
                        Male</label>
                    <label><input type="radio" name="sex" value="0" id="female">
                    Female</label>
                    <br>
                    <label>BP:</label><br>
                    <input class="form-control" type="text" name="BP" id="BP" placeholder="Please Enter BP..." required >
                    <br>
                    <label>Smokes:</label><br>
                    <input type="radio" name="smokes" value="1" >
                    Yes
                    <input type="radio" name="smokes" value="0">
                    No
                    <br>
                    <label>Cholesterol:</label><br>
                    <input class="form-control" type="text" name="cholestrol" id="cholestrol" placeholder="Please Enter Cholesterol..." required>
                    <br>
                    <label>Weight:</label><br>
                    <input class="form-control" type="text" name="weight" id="weight" placeholder="Please Enter Weight..." required>
                    <br>
                    <label>Height:</label><br>
                    <input class="form-control" type="text" name="height" id="height" placeholder="Please Enter Height..." required>
                    <br>
                    <label>Fasting:</label><br>
                    <input class="form-control" type="text" name="fasting" id="Fasting" placeholder="Please Enter Fasting..." required>
                    <br>
                    <label>Family History:</label><br>
                    <input type="radio" name="fh" value="1" id="male">
                    Yes
                    <input type="radio" name="fh" value="0" id="female">
                    No
                    <hr>
                    <input type="submit" class="btn btn-primary" value="Save" name='Save'> 
                </form>
            </div>
        </div>
    </body>
</html>
