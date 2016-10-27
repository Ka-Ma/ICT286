<?php
	$host = "localhost";
	$user = "X32672684"; //katherine's account
	$password = "X32672684";
	$dbc = mysql_connect($host, $user, $password);
	$dbname = "X32628221"; //jack's account
	@mysql_select_db($dbname) or die ('Cannot connect to database ' . mysql_error());
	
	//put submitted in variables
	$username = $_GET['username'];
	$lastname = $_GET['lastname'];
	$phone = $_GET['phone'];
	
	//prevent SQL injection
	$username = mysql_real_escape_string($username);
	$lastname = mysql_real_escape_string($lastname);
	$phone = mysql_real_escape_string($phone);
	
	//query building blocks
	$qB = "SELECT * FROM Customer, Registered WHERE Customer.Username = Registered.Username AND ";
	$qUN = "Customer.Username = '$username'";
	$qJ = " AND ";
	$qLN = "Registered.LastName = '$lastname'";
	$qPH = "Registered.Phone = '$phone'";
	$q = $qB;
	
	//build query
	if($username != "")
	{
		$q = $q . $qUN;
	}
	if($username != "" && $lastname != "")
	{
		$q = $q . $qJ;
	}
	if ($lastname != "")
	{
		$q = $q . $qLN;
	}
	if($username != "" && $lastname != "" && $phone != "")
	{
		$q = $q . $qJ;
	}
	if ($phone != "")
	{
		$q = $q . $qPH;
	}
	
	$result = mysql_query($q);
	
	//returning
	if (mysql_num_rows($result) == 0)
	{
		echo "no result";
	}
	else if (mysql_num_rows($result) > 1) 
	{
		echo "<table><th>Username</th><th>Name</th><th>Phone</th>";
		while ($row=mysql_fetch_array($result)) {
			echo "<tr><td><a href=\"javascript:customerSearch('";
			echo $row['Username'];
			echo "', '";
			echo $row['LastName'];
			echo "', '";
			echo $row['phone'];
			echo "');\">";
			echo $row['Username'];
			echo "</a></td><td>";
			echo $row['FirstName'];
			echo " ";
			echo $row['LastName'];
			echo "</td><td>";
			echo $row['phone'];
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