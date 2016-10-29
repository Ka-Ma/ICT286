<?php
	$host = "localhost";
	$user = "X32672684"; //katherine's account
	$password = "X32672684";
	$dbc = mysql_connect($host, $user, $password);
	$dbname = "X32628221"; //jack's account
	@mysql_select_db($dbname) or die ('Cannot connect to database ' . mysql_error());
	
	var_dump($_GET);
	
	//put submitted in variables
	$custID = $_GET['CustID'];
	$title = $_GET['tititle'];
	$author = $_GET['tiauthor'];
	$isbn = $_GET['tiisbn'];
	$form = $_GET['tiform'];
	$desc = $_GET['tidesc'];
	$fi = $_GET['tifrontImage'];
	$bi = $_GET['tibackImage'];
	$si = $_GET['tispineImage'];
	$pi = $_GET['tipubInfoImage'];
	$oi = $_GET['tiotherImage'];
	
	//set up for image upload
	$target_dir = "../images/TradeIn/";
	
	//need to append the trade in number to start of file which means I need to know the trade in number before i lodge it. combination of date and custid?
	$target_file ;
	
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
	//$result = mysql_query($q);
	
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