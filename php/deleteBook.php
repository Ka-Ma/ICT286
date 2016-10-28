<?php
	$host = "localhost";
        $user = "X32672684"; //katherine's account
        $password = "X32672684";
        $dbc = mysql_connect($host, $user, $password);
        $dbname = "X32628221"; //jack's account
        @mysql_select_db($dbname) or die ('Cannot connect to database ' . mysql_error());

        //put submitted bookID in variable
        $book = $_GET['book'];

        //prevent SQL injection
        $book = mysql_real_escape_string($book);

	//query
	$q1 = "DELETE FROM BookGenre where BookID = $book";
	$q2 = "DELETE FROM StockBook where BookID = $book";
	$result1 = mysql_query($q1);
	$result2 = mysql_query($q2);

	mysql_close();
?>
