<?php
	header("Access-Control-Allow-Origin: http://localhost:8000");
	
	$host = "localhost";
	$user = "X32672684"; //katherine's account
	$password = "X32672684";
	$dbc = mysql_connect($host, $user, $password);
	$dbname = "X32628221"; //jack's account
	@mysql_select_db($dbname) or die ('Cannot connect to database ' . mysql_error());
	
	//put submitted in variables
	$username = $_GET['username'];
	$st = $_GET['st'];
	$sub = $_GET['sub'];
	$state = $_GET['state'];
	$pc = $_GET['pc'];
	$ph = $_GET['ph'];
	$e = $_GET['e'];
	
	//prevent SQL injection
	$username = mysql_real_escape_string($username);
	$st = mysql_real_escape_string($st);
	$sub = mysql_real_escape_string($sub);
	$state = mysql_real_escape_string($state);
	$pc = mysql_real_escape_string($pc);
	$ph = mysql_real_escape_string($ph);
	$e = mysql_real_escape_string($e);
	
	//query
	$q = "UPDATE Registered SET Street = '$st', Suburb = '$sub', State = '$state', PostCode = '$pc', phone = '$ph', email = '$e' WHERE Username  = '$username'";
	$result = mysql_query($q);
	
	//returning
	if($result)
	{
		echo "<p>Your details have been updated.</p>";
	}
	else
	{
		echo "<p>Update failed.</p>";
	}
		
	//clearing up
	//mysql_free_result($result); not needed for boolean results
	mysql_close();
?>