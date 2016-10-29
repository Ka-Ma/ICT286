<?php
	$host = "localhost";
	$user = "X32672684"; //katherine's account
	$password = "X32672684";
	$dbc = mysql_connect($host, $user, $password);
	$dbname = "X32628221"; //jack's account
	@mysql_select_db($dbname) or die ('Cannot connect to database ' . mysql_error());
	
	//put submitted in variables
	$tiID = $_GET['tiID'];
	$status = $_GET['tiStatus'];
	
	//prevent SQL injection
	$tiID = mysql_real_escape_string($tiID);
	$status = mysql_real_escape_string($status);
	
	//query
	$q = "UPDATE TradeBook SET Status = '$status' WHERE TradeBookID  = '$tiID'";
	$result = mysql_query($q);
	
	//returning
	if($result)
	{
		echo "<p>Status updated.</p>";
	}
	else
	{
		echo "<p>Update failed.</p>";
	}
		
	//clearing up
	//mysql_free_result($result); not needed for boolean results
	mysql_close();
?>