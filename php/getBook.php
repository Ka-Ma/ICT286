<?php
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
	
	//returning
	echo "<table>";
	while ($row=mysql_fetch_array($result)) {
		echo "<tr>";
		echo "<td> <img src='";
		echo $row['CoverImage'];
		echo "'</img></td>";
		echo "<td> ";
		echo $row['DateAdded'];
		echo $row['Synopsis'];
		echo "</td></tr>";
	}
	echo "</table>";
	
	//clearing up
	mysql_free_result($result);
	mysql_close();
?>