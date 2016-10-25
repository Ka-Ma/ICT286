<?php
	$host = "localhost";
	$user = "X32672684"; //katherine's account
	$password = "X32672684";
	$dbc = mysql_connect($host, $user, $password);
	$dbname = "X32628221"; //jack's account
	@mysql_select_db($dbname) or die ('Cannot connect to database ' . mysql_error());
	
	//put submitted date in variable
	$date = ($_GET['date']);
			
	//query
	$q = "SELECT * FROM StockBook WHERE DateAdded < '$date' ORDER BY DateAdded DESC LIMIT 5";
	$result = mysql_query($q);
	
	//returning
	echo "<table>";
	echo "<tr>";
	while ($row=mysql_fetch_array($result)) {
		echo "<td> <a href=\"javascript:getBookDetail(";
		echo $row['BookID'];
		echo ")\"> <img class=\"book\" src=\"";
		echo $row['CoverImage'];
		echo "\"</img></a></br>";
		echo "<button type='button' onclick='javascript:addCart(";
		echo $row['BookID'];
		echo ")'>Add to Cart</button></td>";
	}
	echo "</tr>";
	echo "</table>";
	
	//clearing up
	mysql_free_result($result);
	mysql_close();
?>