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
	
	//prevent SQL injection
	$username = mysql_real_escape_string($username);
	$id = mysql_real_escape_string($id);
	
	//query
	$q = "SELECT * from Customer, Registered where Customer.Username = Registered.Username and Customer.Username = '$username'";
	$result = mysql_query($q);
	
	//returning
	while ($row=mysql_fetch_array($result)) {
		echo "<form>";
		echo "Street: <input type='text' id='nSt' value='";
		echo $row['Street'];
		echo "'></br>";
		echo "Suburb: <input type='text' id='nSub' value='";
		echo $row['Suburb'];
		echo "'></br>";
		echo "</form>";
		echo ";";
		echo "<p>Welcome, ";
		echo $row['FirstName'];
		echo " ";
		echo $row['LastName'];
		echo "!</p>";
	}
		
	//clearing up
	mysql_free_result($result);
	mysql_close();
?>