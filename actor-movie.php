<html>
<head>
    <title>Project 1B</title>
</head>

<?php
    echo '<h3> Select the relation you want to create: </h3>';
    # establish a connection
    $db_connection = mysql_connect("localhost", "cs143", "");
    # error handling
    if(!$db_connection) {
        $errmsg = mysql_error($db_connection);
        print "Connection failed: $errmsg <br />";
        exit(1);
    }

    # select a database
    mysql_select_db("TEST", $db_connection);

    $query_actor = "SELECT id, first, last, dob FROM Actor";
    $rs_actor = mysql_query($query_actor, $db_connection);

    $query_movie = "SELECT id, title, year FROM Movie";
    $rs_movie = mysql_query($query_movie, $db_connection);
?>

<form method="POST" action="actor-movie.php">
    Actor:<br>
    <select name="actor_id">
    <?php
        while ($row = mysql_fetch_array($rs_actor)) {
    ?>
            <option value = <?php echo $row[0] ?>> 
                <?php echo $row[1]." ".$row[2]." (".$row[3].")"?>
            </option>
    <?php
        }
    ?>
    </select><br>

    Movie:<br>
    <select name="movie_id">
    <?php
        while ($row = mysql_fetch_array($rs_movie)) {
    ?>
            <option value = <?php echo $row[0] ?>> 
                <?php echo $row[1]." (".$row[2].")"?>
            </option>
    <?php
        }
    ?>
    </select><br>
    
    Role:<br>
    <input type="text" name="role"><br>

    <input type="submit" value="Submit"><br>
</form>

<?php
    $mid = mysql_escape_string($_POST["movie_id"]);
    $aid = mysql_escape_string($_POST["actor_id"]);
    $role = mysql_escape_string($_POST["role"]);
    $query_relation = "INSERT INTO MovieActor(mid, aid, role) VALUES('$mid', '$aid', '$role')";

    $rs_relation = mysql_query($query_relation, $db_connection);
    if(!$rs_relation){
        echo 'Unsupported query!';
    }
    # close the connection
    mysql_close($db_connection);
?>

</html>
