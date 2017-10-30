<!DOCTYPE html>
<html lang="en">
<head>
    <title>Project 1B Add Movie</title>
</head>

<body>
<h1>Add new Movie</h1>

<FORM METHOD = "POST" ACTION = "newMovie.php">

<h4> Title </h4>
<div>
<input type="text" class = "block" placeholder="Movie Title; ie: Frozen" name="title" size="100" maxlength="100" />
</div>

<h4> Company</h4>
<div>
<input type="text" class = "block" placeholder="Company; ie: Paramount" name="company" size="100" maxlength="50" />
</div>

<h4> Year</h4>
<div>
<input type="text" class = "block" placeholder="Year; ie: 1991" name="year" size="100"/>
</div>

<h4> Rating</h4>
<div>
<SELECT name="rating">
<OPTION SELECTED>G
<OPTION>NC
<OPTION>NC-17
<OPTION>PG
<OPTION>PG-13
<OPTION>R
<OPTION>surrendere
</SELECT>
</div>

<h4> Genre </h4>
<div>
<input type="Checkbox" name="action" value="Action">Action
<input type="Checkbox" name="adult" value="Adult">Adult
<input type="Checkbox" name="adventure" value="Adventure">Adventure
<input type="Checkbox" name="animation" value="Animation">Animation
<input type="Checkbox" name="comedy" value="Comedy">Comedy
<input type="Checkbox" name="crime" value="Crime">Crime
<input type="Checkbox" name="documentary" value="Documentary">Documentary
<input type="Checkbox" name="drama" value="Drama">Drama
<input type="Checkbox" name="family" value="Family">Family
<input type="Checkbox" name="fantasy" value="Fantasy">Fantasy
<input type="Checkbox" name="horror" value="Horror">Horror
<input type="Checkbox" name="musical" value="Musical">Musical
<input type="Checkbox" name="mystery" value="Mystery">Mystery
<input type="Checkbox" name="romance" value="Romance">Romance
<input type="Checkbox" name="sci-fi" value="Sci-Fi">Sci-Fi
<input type="Checkbox" name="short" value="Short">Short
<input type="Checkbox" name="thriller" value="Thriller">Thriller
<input type="Checkbox" name="war" value="War">War
<input type="Checkbox" name="western" value="Western">Western
</div>




<div>
<input type="submit" value="Submit" name="submit"> <input type="submit" value="Homepage" name="Homepage">
</div>
</FORM>


<?php

function addGenre($id, $genre, $db_connection){
    if ($id){
        $genre_insert = "INSERT INTO MovieGenre VALUES (".$id.",'".$genre."')";
        mysql_query($genre_insert, $db_connection);
    }
}

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
        $rs = mysql_query("SELECT id FROM MaxMovieID", $db_connection);
        $row = mysql_fetch_array($rs);
        $field = mysql_fetch_field($rs, 0);
        $max_id = $row[$field->name];
        $new_max_id = $max_id+1;

        $rating = $_POST["rating"];
        $query = "INSERT INTO Movie VALUES (".$new_max_id.",'".$_POST["title"]."','".$_POST["year"]."','".$rating."','".$_POST["company"]."')";

        # if missing fields or invalid format of date
        if (!$_POST["title"] || !$_POST["company"] || !$_POST["year"] || !fnmatch("[0-2][0-9][0-9][0-9]", $_POST["year"])){
            echo "<h4> INVALID INPUT </h4>\n";
            echo $query."\n";
        }
        else{
            $update = "UPDATE MaxMovieID SET id = ".$new_max_id;
            # insert to Movie
            mysql_query($query, $db_connection);
            # update MaxPersonID
            mysql_query($update, $db_connection);
            # add genre if any
            addGenre($new_max_id, $_POST["action"], $db_connection);
            addGenre($new_max_id, $_POST["adult"], $db_connection);
            addGenre($new_max_id, $_POST["adventure"], $db_connection);
            addGenre($new_max_id, $_POST["animation"], $db_connection);
            addGenre($new_max_id, $_POST["comedy"], $db_connection);
            addGenre($new_max_id, $_POST["crime"], $db_connection);
            addGenre($new_max_id, $_POST["documentary"], $db_connection);
            addGenre($new_max_id, $_POST["drama"], $db_connection);
            addGenre($new_max_id, $_POST["family"], $db_connection);
            addGenre($new_max_id, $_POST["fantasy"], $db_connection);
            addGenre($new_max_id, $_POST["horror"], $db_connection);
            addGenre($new_max_id, $_POST["musical"], $db_connection);
            addGenre($new_max_id, $_POST["mystery"], $db_connection);
            addGenre($new_max_id, $_POST["romance"], $db_connection);
            addGenre($new_max_id, $_POST["sci-fi"], $db_connection);
            addGenre($new_max_id, $_POST["short"], $db_connection);
            addGenre($new_max_id, $_POST["thriller"], $db_connection);
            addGenre($new_max_id, $_POST["war"], $db_connection);
            addGenre($new_max_id, $_POST["western"], $db_connection);
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