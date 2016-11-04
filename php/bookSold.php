<?php
	header("Access-Control-Allow-Origin: http://localhost:8000");
	
	$host = "localhost";
        $user = "X32672684"; //katherine's account
        $password = "X32672684";
        $dbc = mysql_connect($host, $user, $password);
        $dbname = "X32628221"; //jack's account
        @mysql_select_db($dbname) or die ('Cannot connect to database ' . mysql_error());

        //put checked array into variable
        $Cart = $_REQUEST['Cart'];
        $Cart = json_decode($Cart);
        $size = sizeof($Cart);

	//reduce quantity of each book in cart by 1
	for($i = 0; $i < $size; $i++){
		$q = "UPDATE StockBook set InStock = InStock - 1 WHERE BookID = $Cart[$i]";
		$result = mysql_query($q);
	}
	//no return needed
?>
