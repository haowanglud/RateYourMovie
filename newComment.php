<!DOCTYPE html>
<html lang="en">
<head>
    <title>Project 1B Add People</title>
</head>

<body>
<h1>Add new Comment</h1>

<FORM METHOD = "POST" ACTION = "newComment.php">

<h4> Your Name</h4>
<div>
<input type="text" class = "block" placeholder="Your Full Name; ie: Joe Bruin" name="name" size="100" maxlength="20" />
</div>

<h4> Movie Title</h4>
<div>
<input type="text" class = "block" placeholder="Movie Title; ie: Frozen" name="title" size="100" maxlength="100" />
</div>    

<h4> Rating</h4>
<div>
<SELECT name="rating">
<OPTION SELECTED>0
<OPTION>1
<OPTION>2
<OPTION>3
<OPTION>4
<OPTION>5
</SELECT>
</div>

<h4> Comments </h4>
<textarea name="comment" rows="8" cols="60" maxlength="500" placeholder="Comment, please do not leave it blank"></textarea><br/>

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
    mysql_select_db("CS143", $db_connection);
    if (isset($_POST["submit"])){

        # invalid input
        if (!$_POST["name"] || !$_POST["title"] || !$_POST["comment"]){
            echo "<h4> INVALID INPUT, PLEASE FOLLOW THE FORM SPECIFIED ABOVE</h4>\n";
        }

        else{
            # fetch the mid given title
            $query = "SELECT id FROM Movie WHERE UPPER(title)=UPPER('".$_POST["title"]."')";
            $rs = mysql_query($query, $db_connection);
            if (!$rs){
                echo "No matching movie. Please check if the name is correct, or add this movie to our database first\n";
            }
            else{
                $row = mysql_fetch_array($rs);
                $field = mysql_fetch_field($rs, 0);
                $mid = $row[$field->name];
            }

            # fetch timestamp
            $rs = mysql_query("SELECT CURRENT_TIMESTAMP()", $db_connection);
            $row = mysql_fetch_array($rs);
            $field = mysql_fetch_field($rs, 0);
            $timestamp = $row[$field->name];

            # add the review to database
            $add = "INSERT INTO Review VALUES('". $_POST["name"]. "','" . $timestamp . "'," . $mid . "," . $_POST["rating"] . ",'" . $_POST["comment"] . "')";
        //    echo $add;
            $rt = mysql_query($add, $db_connection);
            if (!$rt){
                echo $add."<br/>";
                echo "insert failed";
            }
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