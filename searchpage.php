<html>
<head>
    <title>Project 1B</title>
</head>

<?php
    echo '<h3> Search for a movie/actor/actress: </h3>';
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
?>

<form method="POST" action="searchpage.php">
    Search:<br>
    <input type="text" name="key" value="" placeholder="">
    <input type="submit" value="Submit" name="submit"><br>
    <input type="submit" value="Homepage" name="Homepage">
</form>

<?php

# indentation
    if (isset($_POST["submit"])){
        $needle = mysql_escape_string($_POST["key"]);
        $query_movie = "SELECT id, title,year FROM Movie WHERE title LIKE '%{$needle}%'";
        $rs_movie = mysql_query($query_movie, $db_connection);

        if(!$rs_movie){
            echo 'Unsupported query or Movie not found';
        }
        else{
?>

<h3> Results from Movie Search: </h3>
<table border="1" cellspace="1" cellpadding="2">
    <tr align="center">
        <?php
                echo '<th>Title</th>';
        ?>
    </tr>
    <?php
            while ($row = mysql_fetch_array($rs_movie)) {
                echo '<tr align="center">';
                if (isset($row[1])){
                    echo '<td>';
                    echo '<a href="show_movie.php?id='.$row[0].'">';
                    echo $row[1].' ('.$row[2].') ';
                    echo '</a>';
                    echo '</td>';
                }
                echo '</tr>';
            }
        }
    ?>
</table>

<?php
        $arr = explode(" ", $needle);
        if (sizeof($arr) == 1){
            $query_actor = "SELECT id, first, last, dob FROM Actor WHERE CONCAT(first, ' ', last) LIKE '%{$needle}%'";
        }
        elseif (sizeof($arr) == 2){
            $query_actor = "SELECT id, first, last, dob FROM Actor WHERE (first LIKE '%{$arr[0]}%' AND last LIKE '%{$arr[1]}%') OR (first LIKE '%{$arr[1]}%' AND last LIKE '%{$arr[0]}%')";
        }
        $rs_actor = mysql_query($query_actor, $db_connection);

        if(!$rs_actor){
            echo 'Unsupported query or Actor not found';
        }
        else{
?>

<h3> Results from Actor/Actress Search: </h3>
<table border="1" cellspace="1" cellpadding="2">
    <tr align="center">
        <?php
            echo '<th>Title</th>';
            echo '<th>Date-of-Birth</th>';
        ?>
    </tr>
    <?php
            while ($row = mysql_fetch_array($rs_actor)) {
                echo '<tr align="center">';
                if ($row){
                    echo '<td>';
                    echo '<a href="show_actor.php?id='.$row[0].'">';
                    echo $row[1]." ".$row[2];
                    echo '</a>';
                    echo '</td>';
                    echo '<td>'.$row[3] .'</td>';
                }
                echo '</tr>';
            }
        }
    }
    ?>
</table>
<?php
    if (isset($_POST["Homepage"])){
        header("Location:homepage.php");
        exit();
    }
    mysql_close($db_connection);
?>

</html>