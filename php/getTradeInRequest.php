<?php
	$host = "localhost";
	$user = "X32672684"; //katherine's account
	$password = "X32672684";
	$dbc = mysql_connect($host, $user, $password);
	$dbname = "X32628221"; //jack's account
	@mysql_select_db($dbname) or die ('Cannot connect to database ' . mysql_error());
	
	//put submitted in variables
	$criteria = $_GET['criteria'];
	
	//prevent SQL injection
	$criteria = mysql_real_escape_string($criteria);
	
	//query building blocks
	select  from'id'
	$qB = "SELECT * FROM TradeBook";  //do i need customer info?
	$qC = "  WHERE CustID = '$criteria'";
	$qE = " ORDER BY Date DESC";
	$q = $qB;
	
	//build query
	if($criteria != "all")
	{
		$q = $q . $qC;
	}
	
	$q = $q . $qE;
	
	$result = mysql_query($q);
	
	//returning
	if (mysql_num_rows($result) == 0)
	{
		echo "no result";
	}
	else if (mysql_num_rows($result) > 1) 
	{
		echo "<table><th>Trade In ID</th><th>Date</th><th>Status</th>";
		while ($row=mysql_fetch_array($result)) {
			echo "<tr><td><a href=\"javascript:getTradeInRequest('";
			echo $row['TradeBookID'];
			echo "', 'ti-accept'";
			echo "');\">";
			echo $row['TradeBookID'];
			echo "</a></td><td>";
			echo $row['Date'];
			echo "</td><td>";
			echo $row['Status'];
			echo "</td></tr>";
		}
		echo "</table>";
	}
	else {
		while ($row=mysql_fetch_array($result)) {
			echo "<form name = 'accInfo'>";
			echo "First Name: <input type = 'text' id='nFN' value ='";
			echo $row['FirstName'];
			echo "'></br>Last Name: <input type='text' id='nLN' value='";
			echo $row['LastName'];
			echo "'></br>Address:<input type='text' id='nSt' value='";
			echo $row['Street'];
			echo "'></br>";
			echo "<input type='text' id='nSub' value='";
			echo $row['Suburb'];
			echo "'><input type='text' id='nState' value='";
			echo $row['State'];
			echo "'><input type ='text' id='nPC' value='";
			echo $row['PostCode'];
			echo "'></br>Phone:<input type ='text' id='nPh' value='";
			echo $row['phone'];
			echo "'></br>Email:<input type ='email' id='nE' value='";
			echo $row['email'];
			echo "'></br>Credit Balance:<input type ='text' id='cb' value='";
			echo $row['CreditBalance'];
			echo "' readonly></br>";
			echo "<button type='button' id='subChange' onclick='javascript:validateAccDetsChange(this.form)'>Submit changes</button>";
			echo "</form>";
			echo "^";
			echo $row['Username'];
			echo "^";
			echo $row['CustID'];
		}
	}
		
	//clearing up
	mysql_free_result($result);
	mysql_close();
?>