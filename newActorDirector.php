<!DOCTYPE html>
<html lang="en">
<head>
    <title>Project 1B Add People</title>
</head>

<body>
<h1>Add new Actor/Director</h1>

<FORM METHOD = "POST" ACTION = "newActorDirector.php">

<h4> Occupation </h4>
<label for="actor">Actor</label>
<input type="radio" name="occupation" id="actor" value="Actor">
<label for="female">Director</label>
<input type="radio" name="occupation" id="director" value="Director">

<h4> First Name</h4>
<div>
<input type="text" class = "block" placeholder="Actor First Name; ie: Joe" name="firstname" size="100" maxlength="20" />
</div>

<h4> Last Name</h4>
<div>
<input type="text" class = "block" placeholder="Actor Last Name; ie: Bruin" name="lastname" size="100" maxlength="20" />
</div>

<h4> Sex </h4>
<label for="male">Male</label>
<input type="radio" name="gender" id="male" value="Male">
<label for="female">Female</label>
<input type="radio" name="gender" id="female" value="Female">

<h4> Date of Birth</h4>
<div class="form-group">
<input type="text" class = "block" placeholder="Date of Birth; ie: 19950521" name="dob" size="100"/>
</div>

<h4> Date of Die</h4>
<div>
<input type="text" class = "block" placeholder="Date of Die: ie: 19950521 (leave it blank if alive)" name="dod" size="100"/>
</div>

<div>
<input type="submit" value="Submit" name="submit"> <input type="submit" value="Homepage" name="Homepage">
</div>
</FORM>


<?php
    # establish a connection
    $db_connection = mysql_connect("localhost", "cs143", "");
    # error handling
    if(!$db_connection) {
        $errmsg = mysql_error($db_connection);
        print "Connection failed: $errmsg <br/>";
        exit(1);
    }

    # select a database
    mysql_select_db("TEST", $db_connection);
    if (isset($_POST["submit"])){
        if ($_POST["occupation"]){
            $rs = mysql_query("SELECT id FROM MaxPersonID", $db_connection);
            $row = mysql_fetch_array($rs);
            $field = mysql_fetch_field($rs, 0);
            $max_id = $row[$field->name];
            $new_max_id = $max_id+1;
            # no input in dod means alive
            if (!$_POST["dod"]){
                $dod = "\N";
            }
            else{
                $dod = $_POST["dod"];
            }
            $query = "INSERT INTO " .$_POST["occupation"]." VALUES (".$new_max_id.",'".$_POST["lastname"]."','".$_POST["firstname"]."','".$_POST["gender"]."','".$_POST["dob"]."','".$dod."')";

            echo $query;
            # if missing fields or invalid format of date
            if (!$_POST["lastname"] || !$_POST["firstname"] || !$_POST["gender"] || !$_POST["dob"] || !fnmatch("[0-9][0-9][0-9][0-9][0-1][0-9][0-3][0-9]", $_POST["dob"]) ){
                echo "<h4> INVALID INPUT </h4>\n";
                echo $query."\n";
            }
            else{
                $update = "UPDATE MaxPersonID SET id = ".$new_max_id;
                # insert the new person
                mysql_query($query, $db_connection);
                # update MaxPersonID
                mysql_query($update, $db_connection);
            }
        }
        else {#occupation not selected
            echo "<h4> INVALID INPUT </h4>\n";
        }
    }

    # TODO: redirect back
    if (isset($_POST["Homepage"])){
        header("Location:homepage.php");
        exit();
    }
?>

</body>
</html>