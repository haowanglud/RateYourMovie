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
    mysql_select_db("CS143", $db_connection);

    $query_director = "SELECT id, first, last, dob FROM Director ORDER BY first, last";
    $rs_director = mysql_query($query_director, $db_connection);

    $query_movie = "SELECT id, title, year FROM Movie ORDER BY title";
    $rs_movie = mysql_query($query_movie, $db_connection);
?>

<form method="POST" action="director-movie.php">
    director:<br>
    <select name="director_id">
        <option selected="">  </option>
    <?php
        while ($row = mysql_fetch_array($rs_director)) {
    ?>
            <option value = <?php echo $row[0] ?>> 
                <?php echo $row[1]." ".$row[2]." ".$row[3]?>
            </option>
    <?php
        }
    ?>
    </select><br>

    Movie:<br>
    <select name="movie_id">
        <option selected="">  </option>
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

    <input type="submit" value="Submit" name="submit"> 
</form>

<form action="homepage.php" > 
    <button type="submit">Homepage</button>
</form> 

<?php

    if (isset($_POST["submit"])){
        $mid = mysql_escape_string($_POST["movie_id"]);
        $did = mysql_escape_string($_POST["director_id"]);
        $query_relation = "INSERT INTO MovieDirector(mid, did) VALUES('$mid', '$did')";

        $rs_relation = mysql_query($query_relation, $db_connection);
        if(!$rs_relation){
            echo 'Unsupported query!';
        }
    }

    if (isset($_POST["Homepage"])){
        header("Location:homepage.php");
        exit();
    }
    # close the connection
    mysql_close($db_connection);
?>

</html>
