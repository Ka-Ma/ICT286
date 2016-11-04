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
	
	//returning
	echo "<table>";
	while ($row=mysql_fetch_array($result)) {
		echo "<tr><th>Title:</th><td>";
		echo $row['Title'];
		echo "</td>";
		echo "<td rowspan='6'> <img class=\"book\" src='";
		echo $row['CoverImage'];
		echo "'</img></td></tr>";
		echo "<tr><th>Author:</th><td>";
		echo $row['Author'];
		echo "</td></tr><tr><th>ISBN:</th><td>";
		echo $row['ISBN'];
		echo "</td></tr><tr><th>Form:</th><td>";
		echo $row['Form'];
		echo "</td></tr><tr><th>Type:</th><td>";
		echo $row['Type'];
		echo "</td></tr><tr><th>Synopsis:</th><td>";
		echo $row['Synopsis'];
		echo "</td></tr><tr><th>Price:</th><td>$";
		echo $row['Price'];
		echo "</td><td>";
		echo "<button type='button' onclick=\"javascript:addCart('$bookID')\">Add to Cart</button></td>";
		echo "</tr>";
	}
	echo "</table>";
	
	//clearing up
	mysql_free_result($result);
	mysql_close();
?>