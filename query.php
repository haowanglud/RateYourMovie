<html>
<head>
    <title>Project 1A</title>
</head>

<?php
    echo "Type an SQL query in the following box:\n
    Example: SELECT * FROM Actor WHERE id=10;"
?>

<FORM METHOD = "POST" ACTION = "query.php">
    <TEXTAREA NAME="query" ROWS="8" COLS="60"><?php echo $_POST["query"];?></TEXTAREA><br/>
    <INPUT TYPE="submit" VALUE="Submit">
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

    // $sanitized_name = mysql_real_escape_string($_POST["query"], $db_connection);
    // $rs = mysql_query($sanitized_name, $db_connection);

    # issuing queries
    $rs = mysql_query($_POST["query"], $db_connection);
    if(!$rs){
        echo 'Unsupported query!';
    }

    else{
        echo '<h3> Result from MySQL: </h3>';

        # col names
        $numfields = mysql_num_fields($rs);
        echo '<table border="1" cellspace="1" cellpadding="2"><tr align="center">';
        for ($i = 0; $i < $numfields; $i++) {
            $field = mysql_fetch_field($rs, $i);
            echo '<th>' . $field->name . '</th>';
        }
        echo '</tr>';

        # fill the table
        while ($row = mysql_fetch_array($rs)) {
            echo '<tr align="center">';
            for ($j = 0; $j < $numfields; $j++) {
                $field = mysql_fetch_field($rs, $j);
                if (empty($row[$field->name])){
                    echo '<td>N/A</td>';
                }
                else{
                    echo '<td>' . $row[$field->name] . '</td>';
                }
            }
            echo '</tr>';
        }
        echo '</table>'; 
    }
    
    # close the connection
    mysql_close($db_connection);
?>

</body>
</html>
