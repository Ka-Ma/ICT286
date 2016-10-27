<?php
	$host = "localhost";
	$user = "X32672684"; //katherine's account
	$password = "X32672684";
	$dbc = mysql_connect($host, $user, $password);
	$dbname = "X32628221"; //jack's account
	@mysql_select_db($dbname) or die ('Cannot connect to database ' . mysql_error());
	
	//put submitted in variables
	$username = $_GET['username'];
	$id = $_GET['id'];
	$newBal = $_GET['newBal'];
	
	//prevent SQL injection
	$username = mysql_real_escape_string($username);
	$id = mysql_real_escape_string($id);
	$newBal = mysql_real_escape_string($newBal);
	
	
	//query
	$q = "UPDATE Customer SET CreditBalance = '$newBal' WHERE Username  = '$username' AND CustID = '$id'";
	$result = mysql_query($q);
	
	//returning
	if($result)
	{
		echo "<p>The balance has been updated.</p>";
	}
	else
	{
		echo "<p>Update failed.</p>";
	}
		
	//clearing up
	//mysql_free_result($result); not needed for boolean results
	mysql_close();
?>