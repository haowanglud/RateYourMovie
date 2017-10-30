<html>
<head>
    <title>Project 1B</title>
</head>
<h1> Information about this Actor/Actress: </h1>

<FORM METHOD = "POST" ACTION = "show_actor.php">
<br/>
<h4> Search for Actor:</h4>
<input type="text" name="key" value="" placeholder="" size="60">
<input type="submit" value="Submit" name="submit"><br>
<br/>
<input type="submit" name="Homepage" value="Homepage">
</FORM>

<?php
    if (isset($_POST["Homepage"])){
        header("Location:homepage.php");
        exit();
    }

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


    if (isset($_POST["submit"])){
        $needle = mysql_escape_string($_POST["key"]);
        $arr = explode(" ", $needle);
        if (sizeof($arr) == 1){
            $query_actor = "SELECT id, first, last, dob FROM Actor WHERE CONCAT(first, ' ', last) LIKE '%{$needle}%'";
        }
        elseif (sizeof($arr) == 2){
            $query_actor = "SELECT id, first, last, dob FROM Actor WHERE (first LIKE '%{$arr[0]}%' AND last LIKE '%{$arr[1]}%') OR (first LIKE '%{$arr[1]}%' AND last LIKE '%{$arr[0]}%')";
        }

        $rs_actor = mysql_query($query_actor, $db_connection);
        $row = mysql_fetch_array($rs_actor);
        $no_rows = FALSE;

        if(!$row){
            echo 'Actor not found <br>';
        }
        else{
?>

<h3> Results from Actor/Actress Search: </h3>
<table border="1" cellspace="1" cellpadding="2">
    <tr align="center">
        <?php
            echo '<th>Name</th>';
            echo '<th>Date-of-Birth</th>';
        ?>
    </tr>
    <?php
            while (!$no_rows) {
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
                $no_rows = !($row = mysql_fetch_array($rs_actor));
            }
        }
    }
    ?>
</table>

<?php
    if ($aid = $_GET["id"]) {
    	$query_1 = "SELECT first, last, sex, dob, dod FROM Actor WHERE id=$aid";
    	$rs_1 = mysql_query($query_1, $db_connection);
    	if(!$rs_1){
    		echo 'Basic Information: N/A';
    	}
    	else{
    		$row_1 = mysql_fetch_array($rs_1);
    		echo 'Name: '.$row_1[0].' '.$row_1[1].' <br>';
    		echo 'Sex: '.$row_1[2]. '<br>';
    		echo 'Date of Birth: '.$row_1[3]. '<br>';
            if ($row_1[3])
                echo 'Date of Death: '.$row_1[4]. '<br>';
    	}

        // Actors
    	$query_movie = "SELECT Movie.id, Movie.title, Movie.year, MovieActor.role FROM Movie, MovieActor WHERE Movie.id=MovieActor.mid AND MovieActor.aid=$aid";
        $rs_movie = mysql_query($query_movie, $db_connection);
?>
<br>
<h3> Filmography: </h3>
<table border="1" cellspace="1" cellpadding="2">
    <tr align="center">
		<th>Movie (year)</th>
        <th>Role</th>
    </tr>
<?php
        if($rs_movie){
            while ($row_movie = mysql_fetch_array($rs_movie)){
                echo '<tr align="center">';
                if (isset($row_movie)){
                    echo '<td>';
                    echo '<a href="show_movie.php?id='.$row_movie[0].'">';
                    echo $row_movie[1]." (".$row_movie[2].") ";
                    echo '</a>';
                    echo '</td>';

                    echo '<td>'.$row_movie[3].'</td>';
                }
                echo '</tr>';
            }
        }
    }
?>
</table>

</html>