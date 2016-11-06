<?php
	header("Access-Control-Allow-Origin: http://localhost:8000");
	
	$host = "localhost";
	$user = "X32672684"; //katherine's account
	$password = "X32672684";
	$dbc = mysql_connect($host, $user, $password);
	$dbname = "X32628221"; //jack's account
	@mysql_select_db($dbname) or die ('Cannot connect to database ' . mysql_error());
	
	//put submitted in variables
	$criteria = explode (",", $_GET['criteria']);
	$returnTo = $_GET['returnTo'];
	$access = $_GET['access'];
	
	//prevent SQL injection
	$criteria[0] = mysql_real_escape_string($criteria[0]);
	$criteria[1] = mysql_real_escape_string($criteria[1]);
	$returnTo = mysql_real_escape_string($returnTo);
	$access = mysql_real_escape_string($access);
	
	//query building blocks
	//select  from'id'
	$qB = "SELECT * FROM TradeBook, Customer, Registered WHERE TradeBook.CustID = Customer.CustID AND Customer.Username = Registered.Username";
	$qC0 = " AND Customer.CustID = '$criteria[0]'";
	$qC1 = " AND TradeBookID = '$criteria[1]'";
	$qE = " ORDER BY Status DESC";
	$q = $qB;
	
	//build query
	if($criteria[0] != "" && $criteria[0] != "all")
	{
		$q = $q . $qC0;
	}
	
	if($criteria[1] != "")
	{
		$q = $q. $qC1;
	}
	
	$q = $q . $qE;
	
	$result = mysql_query($q);

	if($result === FALSE) { 
		die(mysql_error()); //better error handling
	}

	//returning
	if (mysql_num_rows($result) == 0)
	{
		if($access =="staff")
			echo "no result";
	}
	else if (mysql_num_rows($result) > 1) 
	{
		if($access == "customer")
			{
				echo "<h2>Pending Requests</h2>";
			}
		echo "<table><th>Trade In ID</th><th>Date</th><th>Status</th>";
		while ($row=mysql_fetch_array($result)) {
			echo "<tr><td><a href=\"javascript:getTradeInRequest('','";
			echo $row['TradeBookID'];
			echo "', '$returnTo', '$access');\">";
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
			if($access == "customer")
			{
				echo "<h2>Pending Request</h2>";
			}
			echo "<p>Trade-in ID: ";
			echo $row['TradeBookID'];
			echo "</p><p>Date of Request: ";
			echo $row['Date'];
			echo " Status: ";
			echo $row['Status'];
			echo "</p><p>";
			echo $row['Title'];
			echo ", by ";
			echo $row['Author'];
			echo "</p><p>ISBN: ";
			echo $row['ISBN'];
			echo "</p><p>Form: ";
			echo $row['Form'];
			echo "</p><p>Description of condition: ";
			echo $row['Description'];
			echo "</p><p>Images</p>";
			echo "<img class='book' src='";
			echo $row['FrontImage'];
			echo "'><img class='book' src='";
			echo $row['BackImage'];
			echo "'><img class='book' src='";
			echo $row['SpineImage'];
			echo "'><img class='book' src='";
			echo $row['PubInfoImage'];
			echo "'>";
			if($row['OtherImage'] != "")
			{
				echo "<img class='book' src='";
				echo $row['OtherImage'];
				echo "'>";
			}
			
			//form to enter price and status and to submit include hidden fields for other needed data
			if($access=="staff")
			{
				echo "<form name = 'tiquote'>";
				echo "<input type='hidden' name='tiID' value='";
				echo $row['TradeBookID'];
				echo "'>";
				echo "<input type='hidden' name='tiCustE' value='";
				echo $row['email'];
				echo "'>";
				echo "<input type='hidden' name='tiCustN' value='";
				echo $row['FirstName'];
				echo "'>";
				echo "<input type='hidden' name='tiBook' value='";
				echo $row['Title'];
				echo " by ";
				echo $row['Author'];
				echo "'>";
				echo "Quote Price:<input type ='text' name='qP'></br>";
				echo "Set Status:<select name='newStatus'><option value='pending'>Pending Customer Acceptance of Quote</option><option value='rejected'>Rejected</option><option value='finalised'>Finalised</option></select></br>";
				echo "<button type='button' id='statusChange' onclick='javascript:updateStatus(this.form)'>Update Status</button>";
				echo "</form>";
			}
			if($access=="customer" && $row['Status']=="pending")
			{
				echo "<form name = 'ti-accQuote'>";
				echo "<input type='hidden' name='tiID' value='";
				echo $row['TradeBookID'];
				echo "'>";
				echo "Set Status:<select name='newStatus'><option value='accepted'>Accepting Quote</option><option value='rejected'>Rejecting Quote</option></select></br>";
				echo "<button type='button' id='statusChange' onclick='javascript:updateStatus(this.form)'>Update Status</button>";
				echo "</form>";
			}			
		}
	}
		
	//clearing up
	mysql_free_result($result);
	mysql_close();
?>