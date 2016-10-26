<?php
	$host = "localhost";
	$user = "X32672684"; //katherine's account
	$password = "X32672684";
	$dbc = mysql_connect($host, $user, $password);
	$dbname = "X32628221"; //jack's account
	@mysql_select_db($dbname) or die ('Cannot connect to database ' . mysql_error());
	
	//put submitted in variables
	$username = $_GET['username'];
	$newPW = $_GET['nPwd'];
	
	//prevent SQL injection
	$username = mysql_real_escape_string($username);
	$newPW = mysql_real_escape_string($newPW);
	
	//query
	$q = "UPDATE Registered SET Password = '$newPW' where Username = '$username'";
	$result = mysql_query($q);
	
	//returning
	if ($result)
	{
		echo "Your password has successfully been changed";
	}
	else
	{
		echo "Password update failed";
	}
			
	//clearing up
	//mysql_free_result($result); not needed for boolean result
	mysql_close();
?>