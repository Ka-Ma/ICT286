<?php
	header("Access-Control-Allow-Origin: http://localhost:8000");
	
	$host = "localhost";
        $user = "X32672684"; //katherine's account
        $password = "X32672684";
        $dbc = mysql_connect($host, $user, $password);
        $dbname = "X32628221"; //jack's account
        @mysql_select_db($dbname) or die ('Cannot connect to database ' . mysql_error());

        //put submitted bookID in variable
        $bookID = intval($_GET['bookID']);

        //prevent SQL injection
        $bookID = mysql_real_escape_string($bookID);

        //query
        $q = "SELECT * FROM StockBook WHERE bookID = '$bookID'";
        $result = mysql_query($q);
	$stock=mysql_fetch_array($result);

	if($stock['InStock'] > 0)
		echo "inStock";
	else
		echo "outStock";

?>
