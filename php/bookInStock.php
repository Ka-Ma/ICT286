<?php
	header("Access-Control-Allow-Origin: http://localhost:8000");
	
	$host = "localhost";
        $user = "X32672684"; //katherine's account
        $password = "X32672684";
        $dbc = mysql_connect($host, $user, $password);
        $dbname = "X32628221"; //jack's account
        @mysql_select_db($dbname) or die ('Cannot connect to database ' . mysql_error());

        //put submitted ISBN in variable
        $ISBN = $_GET['ISBN'];

        //prevent SQL injection
        $ISBN = mysql_real_escape_string($ISBN);

	//queries
	$q1 = "SELECT * FROM StockBook WHERE ISBN = \"$ISBN\"";
	$result1 = mysql_query($q1);
	$found = mysql_fetch_array($result1);

	//if found, increment InStock by 1
	if($found){
		$q2 = "UPDATE StockBook SET InStock = InStock + 1 WHERE ISBN = \"$ISBN\"";
		$result2 = mysql_query($q2);
	}
	//else, display form to add book
	else{
		echo "not found";
	}

	//clear up
	mysql_free_result($result1);
?>
